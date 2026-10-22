<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KasirController extends Controller
{
    /**
     * Tampilkan halaman kasir / POS.
     */
    public function index(): View
    {
        $categories = Category::withCount(['products' => function ($q) {
            $q->where('stok_produk', '>', 0);
        }])->orderBy('nama_kategori', 'asc')->get();

        $uncategorizedCount = Product::where('stok_produk', '>', 0)
            ->whereNull('id_kategori')
            ->count();

        $products = Product::with('category')
            ->where('stok_produk', '>', 0)
            ->orderBy('nama_produk', 'asc')
            ->get();

        $riwayat = Penjualan::with(['details.product', 'account'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('kasir.index', compact('categories', 'uncategorizedCount', 'products', 'riwayat'));
    }

    /**
     * API: Cari produk by kode atau nama (AJAX/JSON).
     */
    public function searchProduct(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $categoryId = $request->get('kategori', '');

        $products = Product::where('stok_produk', '>', 0)
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('nama_produk', 'like', "%{$query}%")
                        ->orWhere('kode_produk', 'like', "%{$query}%");
                });
            })
            ->when($categoryId && $categoryId !== 'all', function ($q) use ($categoryId) {
                if ($categoryId === 'uncategorized') {
                    $q->whereNull('id_kategori');
                } else {
                    $q->where('id_kategori', $categoryId);
                }
            })
            ->with('category')
            ->limit(50)
            ->get()
            ->map(fn ($p) => [
                'id_produk'       => $p->id_produk,
                'id_kategori'     => $p->id_kategori,
                'kode_produk'     => $p->kode_produk,
                'nama_produk'     => $p->nama_produk,
                'harga_jual'      => (float) $p->harga_jual,
                'harga_beli_terakhir' => (float) $p->harga_beli_terakhir,
                'stok_produk'     => $p->stok_produk,
                'satuan_terkecil' => $p->satuan_terkecil ?? 'pcs',
                'kategori'        => $p->category?->nama_kategori ?? '-',
            ]);

        return response()->json($products);
    }

    /**
     * Proses transaksi penjualan (POST).
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'items'        => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:product,id_produk',
            'items.*.jumlah'    => 'required|integer|min:1',
            'uang_diterima'     => 'required|numeric|min:0',
        ]);

        $items    = $request->input('items');
        $diterima = (float) $request->input('uang_diterima');

        // Hitung total
        $total = 0;
        $detailsData = [];

        foreach ($items as $item) {
            $produk = Product::find($item['id_produk']);
            if (!$produk || $produk->stok_produk < $item['jumlah']) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok produk \"{$produk?->nama_produk}\" tidak mencukupi.",
                ], 422);
            }

            $subtotal = $item['jumlah'] * $produk->harga_jual;
            $total += $subtotal;

            $detailsData[] = [
                'id_produk'         => $produk->id_produk,
                'jumlah'            => $item['jumlah'],
                'harga_beli_saat_ini' => $produk->harga_beli_terakhir ?? 0,
                'harga_jual_saat_ini' => $produk->harga_jual,
                'subtotal'          => $subtotal,
                'produk'            => $produk,
            ];
        }

        if ($diterima < $total) {
            return response()->json([
                'success' => false,
                'message' => 'Uang yang diterima kurang dari total belanja.',
            ], 422);
        }

        $kembalian = $diterima - $total;

        // Generate no invoice
        $noInvoice = 'INV-' . date('Ymd') . '-' . str_pad(
            Penjualan::whereDate('created_at', today())->count() + 1,
            4, '0', STR_PAD_LEFT
        );

        $accountId = session('account_id');
        if (!$accountId && \Illuminate\Support\Facades\Auth::check()) {
            $acc = \App\Models\Account::where('email_akun', \Illuminate\Support\Facades\Auth::user()->email)->first();
            $accountId = $acc?->id_akun;
        }

        $penjualan = null;
        // Simpan transaksi dalam DB transaction
        \DB::transaction(function () use ($noInvoice, $total, $diterima, $kembalian, $detailsData, $accountId, &$penjualan) {
            $penjualan = Penjualan::create([
                'id_akun'           => $accountId,
                'no_invoice'        => $noInvoice,
                'tanggal_penjualan' => now(),
                'total_bayar'       => $total,
                'uang_diterima'     => $diterima,
                'kembalian'         => $kembalian,
            ]);

            foreach ($detailsData as $d) {
                DetailPenjualan::create([
                    'id_penjualan'       => $penjualan->id_penjualan,
                    'id_produk'          => $d['id_produk'],
                    'jumlah'             => $d['jumlah'],
                    'harga_beli_saat_ini' => $d['harga_beli_saat_ini'],
                    'harga_jual_saat_ini' => $d['harga_jual_saat_ini'],
                    'subtotal'           => $d['subtotal'],
                ]);

                // Kurangi stok
                $d['produk']->decrement('stok_produk', $d['jumlah']);
            }
        });

        return response()->json([
            'success'      => true,
            'id_penjualan' => $penjualan?->id_penjualan,
            'no_invoice'   => $noInvoice,
            'total'        => $total,
            'diterima'     => $diterima,
            'kembalian'    => $kembalian,
            'message'      => 'Transaksi berhasil!',
        ]);
    }

    /**
     * Tampilkan riwayat penjualan (GET JSON).
     */
    public function riwayat(): View
    {
        $riwayat = Penjualan::with(['details.product', 'account'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('kasir.riwayat', compact('riwayat'));
    }

    /**
     * Cetak Struk Belanja Kasir (Format Thermal Paper 58mm / 80mm).
     */
    public function printStruk(string|int $id): View
    {
        $penjualan = Penjualan::with(['details.product', 'account'])
            ->where('id_penjualan', $id)
            ->orWhere('no_invoice', $id)
            ->firstOrFail();

        return view('kasir.print', compact('penjualan'));
    }
}
