<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard utama dengan data real-time dari database.
     */
    public function index(): View|\Illuminate\Http\RedirectResponse
    {
        if (session('account_role') === 'kasir') {
            return redirect()->route('kasir.index');
        }

        // 1. Ringkasan Metrik Kartu Atas (Data Real)
        $totalPenjualan = Penjualan::count();
        $totalProduk    = Product::count();
        $avgTransaksi   = Penjualan::avg('total_bayar') ?: 0;
        $stokMenipis    = Product::whereRaw('stok_produk <= COALESCE(stok_minimum, 5)')->count();
        $totalPendapatan= Penjualan::sum('total_bayar') ?: 0;

        $statPenjualan = $totalPenjualan;
        $statProduk    = $totalProduk;
        $statAvgBayar  = round($avgTransaksi);
        $statMenipis   = $stokMenipis;

        // 2. Data Periode Waktu (Hari Ini, Seminggu Terakhir, 1 Bulan Terakhir, 6 Bulan Terakhir, 1 Tahun Terakhir)

        // A. Hari Ini (Slot Jam Operasional 08:00 - 22:00)
        $jamSlots = [
            ['label' => '08:00', 'start' => 8, 'end' => 9],
            ['label' => '10:00', 'start' => 10, 'end' => 11],
            ['label' => '12:00', 'start' => 12, 'end' => 13],
            ['label' => '14:00', 'start' => 14, 'end' => 15],
            ['label' => '16:00', 'start' => 16, 'end' => 17],
            ['label' => '18:00', 'start' => 18, 'end' => 19],
            ['label' => '20:00', 'start' => 20, 'end' => 21],
            ['label' => '22:00', 'start' => 22, 'end' => 23],
        ];

        $todayPenjualan = Penjualan::whereDate('tanggal_penjualan', Carbon::today())->get();
        $hariIniLabels = [];
        $hariIniPenjualan = [];
        $hariIniPendapatan = [];

        foreach ($jamSlots as $slot) {
            $hariIniLabels[] = $slot['label'];
            $filtered = $todayPenjualan->filter(function ($pj) use ($slot) {
                $hour = Carbon::parse($pj->tanggal_penjualan)->hour;
                return $hour >= $slot['start'] && $hour <= $slot['end'];
            });
            $hariIniPenjualan[] = (int) $filtered->count();
            $hariIniPendapatan[] = (float) $filtered->sum('total_bayar');
        }

        // B. Seminggu Terakhir (7 Hari Terakhir)
        $semingguLabels = [];
        $semingguPenjualan = [];
        $semingguPendapatan = [];

        for ($i = 6; $i >= 0; $i--) {
            $d = Carbon::today()->subDays($i);
            $semingguLabels[] = $d->translatedFormat('d M');

            $count = Penjualan::whereDate('tanggal_penjualan', $d->toDateString())->count();
            $sum = Penjualan::whereDate('tanggal_penjualan', $d->toDateString())->sum('total_bayar');

            $semingguPenjualan[] = (int) $count;
            $semingguPendapatan[] = (float) $sum;
        }

        // C. 1 Bulan Terakhir (4 Rentang Minggu)
        $sebulanLabels = [];
        $sebulanPenjualan = [];
        $sebulanPendapatan = [];

        for ($w = 3; $w >= 0; $w--) {
            $startW = Carbon::today()->subDays(($w * 7) + 6)->startOfDay();
            $endW = Carbon::today()->subDays($w * 7)->endOfDay();

            $sebulanLabels[] = $startW->translatedFormat('d M') . ' - ' . $endW->translatedFormat('d M');

            $count = Penjualan::whereBetween('tanggal_penjualan', [$startW, $endW])->count();
            $sum = Penjualan::whereBetween('tanggal_penjualan', [$startW, $endW])->sum('total_bayar');

            $sebulanPenjualan[] = (int) $count;
            $sebulanPendapatan[] = (float) $sum;
        }

        // D. 6 Bulan Terakhir
        $enamBulanLabels = [];
        $enamBulanPenjualan = [];
        $enamBulanPendapatan = [];

        for ($i = 5; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $enamBulanLabels[] = $dt->translatedFormat('M Y');

            $count = Penjualan::whereYear('tanggal_penjualan', $dt->year)
                ->whereMonth('tanggal_penjualan', $dt->month)
                ->count();

            $sum = Penjualan::whereYear('tanggal_penjualan', $dt->year)
                ->whereMonth('tanggal_penjualan', $dt->month)
                ->sum('total_bayar');

            $enamBulanPenjualan[] = (int) $count;
            $enamBulanPendapatan[] = (float) $sum;
        }

        // E. 1 Tahun Terakhir (12 Bulan Terakhir)
        $setahunLabels = [];
        $setahunPenjualan = [];
        $setahunPendapatan = [];

        for ($i = 11; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $setahunLabels[] = $dt->translatedFormat('M Y');

            $count = Penjualan::whereYear('tanggal_penjualan', $dt->year)
                ->whereMonth('tanggal_penjualan', $dt->month)
                ->count();

            $sum = Penjualan::whereYear('tanggal_penjualan', $dt->year)
                ->whereMonth('tanggal_penjualan', $dt->month)
                ->sum('total_bayar');

            $setahunPenjualan[] = (int) $count;
            $setahunPendapatan[] = (float) $sum;
        }

        // Kumpulan Dataset untuk Chart Tren & Waktu Transaksi
        $trendData = [
            'today' => [
                'label' => 'Hari Ini',
                'labels' => $hariIniLabels,
                'penjualan' => $hariIniPenjualan,
                'pendapatan' => $hariIniPendapatan,
            ],
            'week' => [
                'label' => 'Seminggu Terakhir',
                'labels' => $semingguLabels,
                'penjualan' => $semingguPenjualan,
                'pendapatan' => $semingguPendapatan,
            ],
            'month' => [
                'label' => '1 Bulan Terakhir',
                'labels' => $sebulanLabels,
                'penjualan' => $sebulanPenjualan,
                'pendapatan' => $sebulanPendapatan,
            ],
            'months_6' => [
                'label' => '6 Bulan Terakhir',
                'labels' => $enamBulanLabels,
                'penjualan' => $enamBulanPenjualan,
                'pendapatan' => $enamBulanPendapatan,
            ],
            'year' => [
                'label' => '1 Tahun Terakhir',
                'labels' => $setahunLabels,
                'penjualan' => $setahunPenjualan,
                'pendapatan' => $setahunPendapatan,
            ],
        ];

        $timeData = [
            'today' => [
                'label' => 'Hari Ini',
                'desc' => 'Distribusi jam transaksi hari ini',
                'labels' => $hariIniLabels,
                'penjualan' => $hariIniPenjualan,
            ],
            'week' => [
                'label' => 'Seminggu Terakhir',
                'desc' => 'Frekuensi transaksi 7 hari terakhir',
                'labels' => $semingguLabels,
                'penjualan' => $semingguPenjualan,
            ],
            'month' => [
                'label' => '1 Bulan Terakhir',
                'desc' => 'Frekuensi transaksi 4 minggu terakhir',
                'labels' => $sebulanLabels,
                'penjualan' => $sebulanPenjualan,
            ],
            'months_6' => [
                'label' => '6 Bulan Terakhir',
                'desc' => 'Frekuensi transaksi 6 bulan terakhir',
                'labels' => $enamBulanLabels,
                'penjualan' => $enamBulanPenjualan,
            ],
            'year' => [
                'label' => '1 Tahun Terakhir',
                'desc' => 'Frekuensi transaksi 1 tahun terakhir',
                'labels' => $setahunLabels,
                'penjualan' => $setahunPenjualan,
            ],
        ];

        // Variabel lama untuk kompatibilitas
        $bulanLabels = $enamBulanLabels;
        $trenPenjualan = $enamBulanPenjualan;
        $trenPendapatan = $enamBulanPendapatan;
        $hariLabels = $semingguLabels;
        $trenHariPenjualan = $semingguPenjualan;
        $trenHariPendapatan = $semingguPendapatan;
        $jamLabels = $hariIniLabels;
        $jamSeries = $hariIniPenjualan;

        // 3. Data Distribusi Kategori (Donut Chart Real dari Detail Penjualan)
        $kategoriSales = DB::table('detail_penjualan')
            ->join('product', 'detail_penjualan.id_produk', '=', 'product.id_produk')
            ->join('categories', 'product.id_kategori', '=', 'categories.id_kategori')
            ->select('categories.nama_kategori', DB::raw('SUM(detail_penjualan.jumlah) as total_qty'))
            ->groupBy('categories.id_kategori', 'categories.nama_kategori')
            ->orderBy('total_qty', 'desc')
            ->get();

        $kategoriLabels = [];
        $kategoriSeries = [];
        $totalQtyAll = $kategoriSales->sum('total_qty');

        if ($totalQtyAll > 0) {
            foreach ($kategoriSales as $ks) {
                $kategoriLabels[] = $ks->nama_kategori;
                $kategoriSeries[] = (int) round(($ks->total_qty / $totalQtyAll) * 100);
            }
        } else {
            // Fallback ke komposisi produk jika belum ada item terjual sama sekali
            $categoriesWithCount = Category::withCount('products')->get();
            $totalProd = $categoriesWithCount->sum('products_count');
            foreach ($categoriesWithCount as $c) {
                $kategoriLabels[] = $c->nama_kategori;
                $kategoriSeries[] = $totalProd > 0 ? (int) round(($c->products_count / $totalProd) * 100) : 0;
            }
        }

        // 4. Data Target Penjualan Bulan Ini (Donut Target)
        $targetTransaksi = 30; // Target bulanan toko ATK
        $bulanIniTotal = Penjualan::whereMonth('tanggal_penjualan', Carbon::now()->month)
            ->whereYear('tanggal_penjualan', Carbon::now()->year)
            ->count();
        $targetPercentage = $targetTransaksi > 0 ? min(100, (int) round(($bulanIniTotal / $targetTransaksi) * 100)) : 0;

        // 5. Data Sparkline Ungu Kanan Bawah (Tersinkronisasi per periode)
        $purpleData = [
            'today' => [
                'total' => (int) array_sum($hariIniPenjualan),
                'desc'  => 'Transaksi hari ini',
                'series' => $hariIniPenjualan,
                'labels' => $hariIniLabels,
            ],
            'week' => [
                'total' => (int) array_sum($semingguPenjualan),
                'desc'  => 'Transaksi seminggu terakhir',
                'series' => $semingguPenjualan,
                'labels' => $semingguLabels,
            ],
            'month' => [
                'total' => (int) array_sum($sebulanPenjualan),
                'desc'  => 'Transaksi 1 bulan terakhir',
                'series' => $sebulanPenjualan,
                'labels' => $sebulanLabels,
            ],
            'months_6' => [
                'total' => (int) array_sum($enamBulanPenjualan),
                'desc'  => 'Transaksi 6 bulan terakhir',
                'series' => $enamBulanPenjualan,
                'labels' => $enamBulanLabels,
            ],
            'year' => [
                'total' => (int) array_sum($setahunPenjualan),
                'desc'  => 'Transaksi 1 tahun terakhir',
                'series' => $setahunPenjualan,
                'labels' => $setahunLabels,
            ],
        ];

        $sparklineLabels = $enamBulanLabels;
        $sparklineSeries = $enamBulanPenjualan;

        // 6. Kategori Populer / Terlaris Berdasarkan Jumlah Terjual
        $kategoriPopuler = Category::all()->map(function ($cat) {
            $terjual = DB::table('detail_penjualan')
                ->join('product', 'detail_penjualan.id_produk', '=', 'product.id_produk')
                ->where('product.id_kategori', $cat->id_kategori)
                ->sum('detail_penjualan.jumlah');

            return (object) [
                'nama_kategori' => $cat->nama_kategori,
                'terjual' => (int) $terjual,
            ];
        })->sortByDesc('terjual')->values();

        // 7. Data Rinci untuk Modal Pop-Out Titik Tiga (...)
        $daftarPenjualan = Penjualan::with(['details.product', 'account'])
            ->orderBy('tanggal_penjualan', 'desc')
            ->limit(15)
            ->get();

        $daftarProdukAktif = Product::with('category')
            ->where('stok_produk', '>', 0)
            ->orderBy('nama_produk', 'asc')
            ->limit(15)
            ->get();

        $daftarStokMenipis = Product::with('category')
            ->whereRaw('stok_produk <= COALESCE(stok_minimum, 5)')
            ->orderBy('stok_produk', 'asc')
            ->get();

        $transaksiTertinggi = Penjualan::max('total_bayar') ?: 0;
        $transaksiTerendah = Penjualan::min('total_bayar') ?: 0;

        return view('dashboard.index', compact(
            'statPenjualan',
            'statProduk',
            'statAvgBayar',
            'statMenipis',
            'totalPendapatan',
            'kategoriPopuler',
            'bulanLabels',
            'trenPenjualan',
            'trenPendapatan',
            'hariLabels',
            'trenHariPenjualan',
            'trenHariPendapatan',
            'kategoriLabels',
            'kategoriSeries',
            'jamLabels',
            'jamSeries',
            'trendData',
            'timeData',
            'purpleData',
            'targetTransaksi',
            'targetPercentage',
            'sparklineLabels',
            'sparklineSeries',
            'bulanIniTotal',
            'daftarPenjualan',
            'daftarProdukAktif',
            'daftarStokMenipis',
            'transaksiTertinggi',
            'transaksiTerendah'
        ));
    }
}
