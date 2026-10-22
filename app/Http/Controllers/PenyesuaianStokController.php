<?php

namespace App\Http\Controllers;

use App\Models\PenyesuaianStok;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PenyesuaianStokController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        if (session('account_role') === 'kasir') {
            return redirect()->route('kasir.index')->with('error', 'Akses ditolak. Fitur Penyesuaian Stok hanya dapat diakses oleh Administrator / Owner.');
        }

        $search = $request->query('search');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $jenis = $request->query('jenis'); // 'tambah', 'kurang', or null

        $query = PenyesuaianStok::with(['product.category'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($subQ) use ($search) {
                    $subQ->where('keterangan', 'like', "%{$search}%")
                        ->orWhereHas('product', function ($pQ) use ($search) {
                            $pQ->where('nama_produk', 'like', "%{$search}%")
                                ->orWhere('kode_produk', 'like', "%{$search}%");
                        });
                });
            })
            ->when($startDate, function ($q) use ($startDate) {
                $q->whereDate('tanggal_cek', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                $q->whereDate('tanggal_cek', '<=', $endDate);
            })
            ->when($jenis === 'tambah', function ($q) {
                $q->where('jumlah_selisih', '>', 0);
            })
            ->when($jenis === 'kurang', function ($q) {
                $q->where('jumlah_selisih', '<', 0);
            });

        // Metrik Statistik KPI
        $totalOpname = (clone $query)->count();
        $totalBertambah = PenyesuaianStok::where('jumlah_selisih', '>', 0)->sum('jumlah_selisih') ?? 0;
        $totalBerkurang = abs(PenyesuaianStok::where('jumlah_selisih', '<', 0)->sum('jumlah_selisih') ?? 0);

        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        $opnameBulanIni = PenyesuaianStok::whereBetween('tanggal_cek', [$startOfMonth, $endOfMonth])->count();

        $penyesuaian = $query->orderBy('tanggal_cek', 'desc')
            ->orderBy('id_penyesuaian', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Daftar produk untuk pilihan dropdown
        $products = Product::orderBy('nama_produk', 'asc')->get();

        return view('penyesuaian.index', compact(
            'penyesuaian',
            'products',
            'search',
            'startDate',
            'endDate',
            'jenis',
            'totalOpname',
            'totalBertambah',
            'totalBerkurang',
            'opnameBulanIni'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_produk' => 'required|exists:product,id_produk',
            'tanggal_cek' => 'required|date',
            'jumlah_selisih' => 'required|integer|not_in:0',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'id_produk.required' => 'Pilih produk yang disesuaikan.',
            'id_produk.exists' => 'Produk yang dipilih tidak valid.',
            'tanggal_cek.required' => 'Tanggal pengecekan wajib diisi.',
            'tanggal_cek.date' => 'Format tanggal tidak valid.',
            'jumlah_selisih.required' => 'Jumlah selisih penyesuaian wajib diisi.',
            'jumlah_selisih.not_in' => 'Jumlah selisih tidak boleh 0 (harus ada penambahan atau pengurangan).',
        ]);

        DB::transaction(function () use ($validated) {
            PenyesuaianStok::create([
                'id_produk' => $validated['id_produk'],
                'tanggal_cek' => $validated['tanggal_cek'],
                'jumlah_selisih' => (int) $validated['jumlah_selisih'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // Sesuaikan stok master produk
            $product = Product::findOrFail($validated['id_produk']);
            $product->stok_produk = max(0, ($product->stok_produk ?? 0) + (int) $validated['jumlah_selisih']);
            $product->save();
        });

        return redirect()->route('penyesuaian.index')->with('success', 'Penyesuaian stok berhasil dicatat dan stok produk telah diperbarui!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $penyesuaian = PenyesuaianStok::findOrFail($id);

        $validated = $request->validate([
            'id_produk' => 'required|exists:product,id_produk',
            'tanggal_cek' => 'required|date',
            'jumlah_selisih' => 'required|integer|not_in:0',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'id_produk.required' => 'Pilih produk yang disesuaikan.',
            'id_produk.exists' => 'Produk yang dipilih tidak valid.',
            'tanggal_cek.required' => 'Tanggal pengecekan wajib diisi.',
            'tanggal_cek.date' => 'Format tanggal tidak valid.',
            'jumlah_selisih.required' => 'Jumlah selisih penyesuaian wajib diisi.',
            'jumlah_selisih.not_in' => 'Jumlah selisih tidak boleh 0.',
        ]);

        DB::transaction(function () use ($penyesuaian, $validated) {
            $oldProductId = $penyesuaian->id_produk;
            $oldSelisih = (int) $penyesuaian->jumlah_selisih;
            $newProductId = $validated['id_produk'];
            $newSelisih = (int) $validated['jumlah_selisih'];

            if ($oldProductId == $newProductId) {
                // Produk sama: sesuaikan delta selisih
                $diff = $newSelisih - $oldSelisih;
                $product = Product::findOrFail($newProductId);
                $product->stok_produk = max(0, ($product->stok_produk ?? 0) + $diff);
                $product->save();
            } else {
                // Produk berbeda: batalkan selisih lama pada produk lama, terapkan selisih baru ke produk baru
                if ($oldProductId) {
                    $oldProduct = Product::find($oldProductId);
                    if ($oldProduct) {
                        $oldProduct->stok_produk = max(0, ($oldProduct->stok_produk ?? 0) - $oldSelisih);
                        $oldProduct->save();
                    }
                }

                $newProduct = Product::findOrFail($newProductId);
                $newProduct->stok_produk = max(0, ($newProduct->stok_produk ?? 0) + $newSelisih);
                $newProduct->save();
            }

            $penyesuaian->update([
                'id_produk' => $newProductId,
                'tanggal_cek' => $validated['tanggal_cek'],
                'jumlah_selisih' => $newSelisih,
                'keterangan' => $validated['keterangan'] ?? null,
            ]);
        });

        return redirect()->route('penyesuaian.index')->with('success', 'Data penyesuaian stok berhasil diperbarui!');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $penyesuaian = PenyesuaianStok::findOrFail($id);

                // Kembalikan efek penyesuaian dari stok produk
                if ($penyesuaian->id_produk) {
                    $product = Product::find($penyesuaian->id_produk);
                    if ($product) {
                        $product->stok_produk = max(0, ($product->stok_produk ?? 0) - (int) $penyesuaian->jumlah_selisih);
                        $product->save();
                    }
                }

                $penyesuaian->delete();
            });

            return redirect()->route('penyesuaian.index')->with('success', 'Data penyesuaian stok berhasil dihapus dan stok produk telah dikembalikan!');
        } catch (\Exception $e) {
            return redirect()->route('penyesuaian.index')->with('error', 'Gagal menghapus data penyesuaian stok: ' . $e->getMessage());
        }
    }
}
