<?php

namespace App\Http\Controllers;

use App\Models\PembelianStok;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PembelianStokController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        if (session('account_role') === 'kasir') {
            return redirect()->route('kasir.index')->with('error', 'Akses ditolak. Fitur Pembelian Stok hanya dapat diakses oleh Administrator / Owner.');
        }

        $search = $request->query('search');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Query dasar dengan relasi product & category
        $query = PembelianStok::with(['product.category'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('product', function ($sub) use ($search) {
                    $sub->where('nama_produk', 'like', "%{$search}%")
                        ->orWhere('kode_produk', 'like', "%{$search}%");
                });
            })
            ->when($startDate, function ($q) use ($startDate) {
                $q->whereDate('tanggal_masuk', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                $q->whereDate('tanggal_masuk', '<=', $endDate);
            });

        // Statistik KPI (sebelum pagination)
        $totalTransaksi = (clone $query)->count();
        $totalPengeluaran = (clone $query)->sum('total_harga_beli') ?? 0;
        $totalUnitMasuk = (clone $query)->sum('jumlah_barang_masuk') ?? 0;

        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        $pembelianBulanIni = PembelianStok::whereBetween('tanggal_masuk', [$startOfMonth, $endOfMonth])
            ->sum('total_harga_beli') ?? 0;

        $pembelian = $query->orderBy('tanggal_masuk', 'desc')
            ->orderBy('id_pembelian', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Daftar produk untuk pilihan dropdown di form pembelian
        $products = Product::orderBy('nama_produk', 'asc')->get();

        return view('pembelian.index', compact(
            'pembelian',
            'products',
            'search',
            'startDate',
            'endDate',
            'totalTransaksi',
            'totalPengeluaran',
            'totalUnitMasuk',
            'pembelianBulanIni'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_produk' => 'required|exists:product,id_produk',
            'tanggal_masuk' => 'required|date',
            'jumlah_barang_masuk' => 'required|integer|min:1',
            'harga_beli_satuan' => 'required|numeric|min:0',
        ], [
            'id_produk.required' => 'Pilih produk yang dibeli.',
            'id_produk.exists' => 'Produk yang dipilih tidak valid.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Format tanggal tidak valid.',
            'jumlah_barang_masuk.required' => 'Jumlah barang masuk wajib diisi.',
            'jumlah_barang_masuk.min' => 'Jumlah barang minimal 1.',
            'harga_beli_satuan.required' => 'Harga beli satuan wajib diisi.',
            'harga_beli_satuan.numeric' => 'Harga beli harus berupa angka.',
        ]);

        $totalHargaBeli = $validated['jumlah_barang_masuk'] * $validated['harga_beli_satuan'];

        DB::transaction(function () use ($validated, $totalHargaBeli) {
            PembelianStok::create([
                'id_produk' => $validated['id_produk'],
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'jumlah_barang_masuk' => $validated['jumlah_barang_masuk'],
                'harga_beli_satuan' => $validated['harga_beli_satuan'],
                'total_harga_beli' => $totalHargaBeli,
            ]);

            // Update stok produk & update harga beli terakhir
            $product = Product::findOrFail($validated['id_produk']);
            $product->stok_produk = ($product->stok_produk ?? 0) + $validated['jumlah_barang_masuk'];
            $product->harga_beli_terakhir = $validated['harga_beli_satuan'];
            $product->save();
        });

        return redirect()->route('pembelian.index')->with('success', 'Transaksi pembelian stok berhasil dicatat dan stok produk telah ditambahkan!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $pembelian = PembelianStok::findOrFail($id);

        $validated = $request->validate([
            'id_produk' => 'required|exists:product,id_produk',
            'tanggal_masuk' => 'required|date',
            'jumlah_barang_masuk' => 'required|integer|min:1',
            'harga_beli_satuan' => 'required|numeric|min:0',
        ], [
            'id_produk.required' => 'Pilih produk yang dibeli.',
            'id_produk.exists' => 'Produk yang dipilih tidak valid.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Format tanggal tidak valid.',
            'jumlah_barang_masuk.required' => 'Jumlah barang masuk wajib diisi.',
            'jumlah_barang_masuk.min' => 'Jumlah barang minimal 1.',
            'harga_beli_satuan.required' => 'Harga beli satuan wajib diisi.',
            'harga_beli_satuan.numeric' => 'Harga beli harus berupa angka.',
        ]);

        $totalHargaBeli = $validated['jumlah_barang_masuk'] * $validated['harga_beli_satuan'];

        DB::transaction(function () use ($pembelian, $validated, $totalHargaBeli) {
            $oldProductId = $pembelian->id_produk;
            $oldJumlah = (int) $pembelian->jumlah_barang_masuk;
            $newProductId = $validated['id_produk'];
            $newJumlah = (int) $validated['jumlah_barang_masuk'];

            if ($oldProductId == $newProductId) {
                // Produk sama: sesuaikan selisih stok
                $selisih = $newJumlah - $oldJumlah;
                $product = Product::findOrFail($newProductId);
                $product->stok_produk = max(0, ($product->stok_produk ?? 0) + $selisih);
                $product->harga_beli_terakhir = $validated['harga_beli_satuan'];
                $product->save();
            } else {
                // Produk berganti: kurangi produk lama, tambahkan ke produk baru
                if ($oldProductId) {
                    $oldProduct = Product::find($oldProductId);
                    if ($oldProduct) {
                        $oldProduct->stok_produk = max(0, ($oldProduct->stok_produk ?? 0) - $oldJumlah);
                        $oldProduct->save();
                    }
                }

                $newProduct = Product::findOrFail($newProductId);
                $newProduct->stok_produk = ($newProduct->stok_produk ?? 0) + $newJumlah;
                $newProduct->harga_beli_terakhir = $validated['harga_beli_satuan'];
                $newProduct->save();
            }

            $pembelian->update([
                'id_produk' => $newProductId,
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'jumlah_barang_masuk' => $newJumlah,
                'harga_beli_satuan' => $validated['harga_beli_satuan'],
                'total_harga_beli' => $totalHargaBeli,
            ]);
        });

        return redirect()->route('pembelian.index')->with('success', 'Data transaksi pembelian stok berhasil diperbarui!');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $pembelian = PembelianStok::findOrFail($id);

                // Kembalikan/kurangi stok produk sejumlah barang masuk yang dihapus
                if ($pembelian->id_produk) {
                    $product = Product::find($pembelian->id_produk);
                    if ($product) {
                        $product->stok_produk = max(0, ($product->stok_produk ?? 0) - (int) $pembelian->jumlah_barang_masuk);
                        $product->save();
                    }
                }

                $pembelian->delete();
            });

            return redirect()->route('pembelian.index')->with('success', 'Data pembelian stok berhasil dihapus dan stok produk telah disesuaikan!');
        } catch (\Exception $e) {
            return redirect()->route('pembelian.index')->with('error', 'Gagal menghapus data pembelian stok: ' . $e->getMessage());
        }
    }
}
