<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\PembelianStok;
use App\Models\Penjualan;
use App\Models\PenyesuaianStok;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman utama Laporan & Analisis Laba Rugi.
     */
    public function index(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        if (session('account_role') === 'kasir') {
            return redirect()->route('kasir.index')->with('error', 'Akses ditolak. Halaman Laporan hanya dapat diakses oleh Administrator / Owner.');
        }

        $periode = $request->query('periode', 'bulan_ini');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Tentukan rentang tanggal default berdasarkan preset
        $now = Carbon::now();
        switch ($periode) {
            case 'hari_ini':
                $startDate = $now->copy()->toDateString();
                $endDate = $now->copy()->toDateString();
                break;
            case '7_hari':
                $startDate = $now->copy()->subDays(6)->toDateString();
                $endDate = $now->copy()->toDateString();
                break;
            case 'bulan_lalu':
                $startDate = $now->copy()->subMonth()->startOfMonth()->toDateString();
                $endDate = $now->copy()->subMonth()->endOfMonth()->toDateString();
                break;
            case 'tahun_ini':
                $startDate = $now->copy()->startOfYear()->toDateString();
                $endDate = $now->copy()->toDateString();
                break;
            case 'custom':
                // Gunakan custom input atau fallback ke bulan ini jika kosong
                $startDate = $startDate ?: $now->copy()->startOfMonth()->toDateString();
                $endDate = $endDate ?: $now->copy()->toDateString();
                break;
            case 'bulan_ini':
            default:
                $periode = 'bulan_ini';
                $startDate = $now->copy()->startOfMonth()->toDateString();
                $endDate = $now->copy()->toDateString();
                break;
        }

        $startDateTime = Carbon::parse($startDate)->startOfDay();
        $endDateTime = Carbon::parse($endDate)->endOfDay();

        // 1. STATISTIK PENJUALAN & OMZET
        $queryPenjualan = Penjualan::whereBetween('tanggal_penjualan', [$startDateTime, $endDateTime]);
        $totalTransaksi = (clone $queryPenjualan)->count();
        $totalOmzet = (clone $queryPenjualan)->sum('total_bayar') ?? 0;

        // 2. STATISTIK HPP (MODAL POKOK PENJUALAN)
        $totalHpp = DetailPenjualan::whereHas('penjualan', function ($q) use ($startDateTime, $endDateTime) {
            $q->whereBetween('tanggal_penjualan', [$startDateTime, $endDateTime]);
        })->selectRaw('SUM(jumlah * COALESCE(harga_beli_saat_ini, 0)) as total_hpp')->value('total_hpp') ?? 0;

        // 3. LABA KOTOR (GROSS PROFIT) & MARGIN
        $labaKotor = $totalOmzet - $totalHpp;
        $marginLabaKotor = $totalOmzet > 0 ? ($labaKotor / $totalOmzet) * 100 : 0;

        // 4. PEMBELIAN STOK (PENGELUARAN KULAKAN)
        $totalPembelian = PembelianStok::whereBetween('tanggal_masuk', [$startDate, $endDate])
            ->sum('total_harga_beli') ?? 0;

        // 5. KERUGIAN BARANG RUSAK / HILANG DARI OPNAME
        $penyesuaianMinus = PenyesuaianStok::with('product')
            ->whereBetween('tanggal_cek', [$startDate, $endDate])
            ->where('jumlah_selisih', '<', 0)
            ->get();

        $totalKerugianOpname = $penyesuaianMinus->sum(function ($item) {
            $hargaBeli = $item->product ? ($item->product->harga_beli_terakhir ?? 0) : 0;
            return abs($item->jumlah_selisih) * $hargaBeli;
        });

        // 6. ESTIMASI LABA BERSIH OPERASIONAL
        $labaBersihEstimasi = $labaKotor - $totalKerugianOpname;

        // 7. DATA GRAFIK TREN (Omzet vs HPP vs Laba)
        $diffDays = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
        $chartLabels = [];
        $chartOmzet = [];
        $chartHpp = [];
        $chartLaba = [];

        if ($diffDays <= 31) {
            // Tampilan per hari
            $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
            foreach ($period as $date) {
                $curDate = $date->format('Y-m-d');
                $chartLabels[] = $date->format('d M');

                $omzetHari = Penjualan::whereDate('tanggal_penjualan', $curDate)->sum('total_bayar') ?? 0;
                $hppHari = DetailPenjualan::whereHas('penjualan', function ($q) use ($curDate) {
                    $q->whereDate('tanggal_penjualan', $curDate);
                })->selectRaw('SUM(jumlah * COALESCE(harga_beli_saat_ini, 0)) as total_hpp')->value('total_hpp') ?? 0;

                $chartOmzet[] = (float) $omzetHari;
                $chartHpp[] = (float) $hppHari;
                $chartLaba[] = (float) ($omzetHari - $hppHari);
            }
        } else {
            // Tampilan per bulan jika periode lebih dari sebulan
            $periodMonths = \Carbon\CarbonPeriod::create($startDate, '1 month', $endDate);
            foreach ($periodMonths as $date) {
                $year = $date->year;
                $month = $date->month;
                $chartLabels[] = $date->translatedFormat('M Y');

                $omzetBulan = Penjualan::whereYear('tanggal_penjualan', $year)
                    ->whereMonth('tanggal_penjualan', $month)
                    ->sum('total_bayar') ?? 0;

                $hppBulan = DetailPenjualan::whereHas('penjualan', function ($q) use ($year, $month) {
                    $q->whereYear('tanggal_penjualan', $year)
                      ->whereMonth('tanggal_penjualan', $month);
                })->selectRaw('SUM(jumlah * COALESCE(harga_beli_saat_ini, 0)) as total_hpp')->value('total_hpp') ?? 0;

                $chartOmzet[] = (float) $omzetBulan;
                $chartHpp[] = (float) $hppBulan;
                $chartLaba[] = (float) ($omzetBulan - $hppBulan);
            }
        }

        // 8. TABEL 1: DAFTAR TRANSAKSI PENJUALAN
        $penjualanList = Penjualan::with(['account', 'details.product'])
            ->whereBetween('tanggal_penjualan', [$startDateTime, $endDateTime])
            ->orderBy('tanggal_penjualan', 'desc')
            ->paginate(10, ['*'], 'penjualan_page')
            ->withQueryString();

        // 9. TABEL 2: PERFORMA & MARGIN PER PRODUK
        $produkPerforma = DetailPenjualan::join('penjualan', 'detail_penjualan.id_penjualan', '=', 'penjualan.id_penjualan')
            ->join('product', 'detail_penjualan.id_produk', '=', 'product.id_produk')
            ->leftJoin('categories', 'product.id_kategori', '=', 'categories.id_kategori')
            ->whereBetween('penjualan.tanggal_penjualan', [$startDateTime, $endDateTime])
            ->select(
                'product.id_produk',
                'product.nama_produk',
                'product.kode_produk',
                'categories.nama_kategori',
                DB::raw('SUM(detail_penjualan.jumlah) as total_qty'),
                DB::raw('SUM(detail_penjualan.subtotal) as total_omzet'),
                DB::raw('SUM(detail_penjualan.jumlah * COALESCE(detail_penjualan.harga_beli_saat_ini, 0)) as total_modal'),
                DB::raw('SUM(detail_penjualan.subtotal - (detail_penjualan.jumlah * COALESCE(detail_penjualan.harga_beli_saat_ini, 0))) as total_laba')
            )
            ->groupBy('product.id_produk', 'product.nama_produk', 'product.kode_produk', 'categories.nama_kategori')
            ->orderByDesc('total_laba')
            ->get();

        // 10. TABEL 3: REKAP PEMBELIAN STOK (KULAKAN)
        $pembelianList = PembelianStok::with(['product.category'])
            ->whereBetween('tanggal_masuk', [$startDate, $endDate])
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        // 11. TABEL 4: REKAP PENYESUAIAN STOK (LOSS / OPNAME)
        $penyesuaianList = PenyesuaianStok::with(['product.category'])
            ->whereBetween('tanggal_cek', [$startDate, $endDate])
            ->orderBy('tanggal_cek', 'desc')
            ->get();

        return view('laporan.index', compact(
            'periode',
            'startDate',
            'endDate',
            'totalTransaksi',
            'totalOmzet',
            'totalHpp',
            'labaKotor',
            'marginLabaKotor',
            'totalPembelian',
            'totalKerugianOpname',
            'labaBersihEstimasi',
            'chartLabels',
            'chartOmzet',
            'chartHpp',
            'chartLaba',
            'penjualanList',
            'produkPerforma',
            'pembelianList',
            'penyesuaianList'
        ));
    }

    /**
     * Tampilan cetak laporan (Print Friendly).
     */
    public function print(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        if (session('account_role') === 'kasir') {
            return redirect()->route('kasir.index');
        }

        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->toDateString());

        $startDateTime = Carbon::parse($startDate)->startOfDay();
        $endDateTime = Carbon::parse($endDate)->endOfDay();

        $queryPenjualan = Penjualan::whereBetween('tanggal_penjualan', [$startDateTime, $endDateTime]);
        $totalTransaksi = (clone $queryPenjualan)->count();
        $totalOmzet = (clone $queryPenjualan)->sum('total_bayar') ?? 0;

        $totalHpp = DetailPenjualan::whereHas('penjualan', function ($q) use ($startDateTime, $endDateTime) {
            $q->whereBetween('tanggal_penjualan', [$startDateTime, $endDateTime]);
        })->selectRaw('SUM(jumlah * COALESCE(harga_beli_saat_ini, 0)) as total_hpp')->value('total_hpp') ?? 0;

        $labaKotor = $totalOmzet - $totalHpp;
        $totalPembelian = PembelianStok::whereBetween('tanggal_masuk', [$startDate, $endDate])->sum('total_harga_beli') ?? 0;

        $penyesuaianMinus = PenyesuaianStok::with('product')
            ->whereBetween('tanggal_cek', [$startDate, $endDate])
            ->where('jumlah_selisih', '<', 0)
            ->get();

        $totalKerugianOpname = $penyesuaianMinus->sum(function ($item) {
            $hargaBeli = $item->product ? ($item->product->harga_beli_terakhir ?? 0) : 0;
            return abs($item->jumlah_selisih) * $hargaBeli;
        });

        $labaBersihEstimasi = $labaKotor - $totalKerugianOpname;

        $penjualanList = Penjualan::with(['account', 'details.product'])
            ->whereBetween('tanggal_penjualan', [$startDateTime, $endDateTime])
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        $pembelianList = PembelianStok::with('product')
            ->whereBetween('tanggal_masuk', [$startDate, $endDate])
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        return view('laporan.print', compact(
            'startDate',
            'endDate',
            'totalTransaksi',
            'totalOmzet',
            'totalHpp',
            'labaKotor',
            'totalPembelian',
            'totalKerugianOpname',
            'labaBersihEstimasi',
            'penjualanList',
            'pembelianList'
        ));
    }

    /**
     * Ekspor Laporan Transaksi & Keuntungan ke format CSV (Excel).
     */
    public function exportCsv(Request $request): Response|\Illuminate\Http\RedirectResponse
    {
        if (session('account_role') === 'kasir') {
            return redirect()->route('kasir.index');
        }

        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->toDateString());

        $startDateTime = Carbon::parse($startDate)->startOfDay();
        $endDateTime = Carbon::parse($endDate)->endOfDay();

        $penjualan = Penjualan::with(['account', 'details.product'])
            ->whereBetween('tanggal_penjualan', [$startDateTime, $endDateTime])
            ->orderBy('tanggal_penjualan', 'asc')
            ->get();

        $filename = 'Laporan_Keuangan_ATKSMART_' . $startDate . '_sd_' . $endDate . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($penjualan, $startDate, $endDate) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM untuk Microsoft Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['LAPORAN PENJUALAN & LABA KOTOR - ATK SMART']);
            fputcsv($handle, ['Periode:', $startDate . ' s/d ' . $endDate]);
            fputcsv($handle, []);

            // Header Tabel
            fputcsv($handle, [
                'No Invoice',
                'Tanggal & Waktu',
                'Kasir / Petugas',
                'Item Terjual',
                'Total Omzet (Rp)',
                'Modal Pokok HPP (Rp)',
                'Laba Kotor (Rp)',
                'Margin Keuntungan (%)',
            ]);

            $totalOmzetAll = 0;
            $totalHppAll = 0;
            $totalLabaAll = 0;

            foreach ($penjualan as $item) {
                $omzet = (float) $item->total_bayar;
                $hpp = $item->details->sum(fn ($d) => $d->jumlah * ($d->harga_beli_saat_ini ?? 0));
                $laba = $omzet - $hpp;
                $margin = $omzet > 0 ? round(($laba / $omzet) * 100, 1) : 0;

                $totalOmzetAll += $omzet;
                $totalHppAll += $hpp;
                $totalLabaAll += $laba;

                $itemsSummary = $item->details->map(fn ($d) => ($d->product->nama_produk ?? 'Produk') . ' (' . $d->jumlah . 'x)')->implode(', ');

                fputcsv($handle, [
                    $item->no_invoice,
                    $item->tanggal_penjualan ? $item->tanggal_penjualan->format('Y-m-d H:i') : '-',
                    $item->account->nama_akun ?? 'Administrator',
                    $itemsSummary,
                    $omzet,
                    $hpp,
                    $laba,
                    $margin . '%',
                ]);
            }

            fputcsv($handle, []);
            fputcsv($handle, [
                'TOTAL KESELURUHAN',
                '',
                '',
                '',
                $totalOmzetAll,
                $totalHppAll,
                $totalLabaAll,
                ($totalOmzetAll > 0 ? round(($totalLabaAll / $totalOmzetAll) * 100, 1) : 0) . '%',
            ]);

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
