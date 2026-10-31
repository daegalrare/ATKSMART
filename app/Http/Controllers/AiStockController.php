<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\DetailPenjualan;
use App\Models\PembelianStok;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AiStockController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $thirtyDaysAgo = $now->copy()->subDays(30);
        $sevenDaysAgo  = $now->copy()->subDays(7);

        // Ambil semua produk beserta kategori
        $products = Product::with('category')->get();

        // Hitung total penjualan per produk dalam 30 hari terakhir
        $salesLast30 = DetailPenjualan::join('penjualan', 'detail_penjualan.id_penjualan', '=', 'penjualan.id_penjualan')
            ->where('penjualan.created_at', '>=', $thirtyDaysAgo)
            ->select('detail_penjualan.id_produk', DB::raw('SUM(detail_penjualan.jumlah) as total_qty'))
            ->groupBy('detail_penjualan.id_produk')
            ->pluck('total_qty', 'id_produk');

        // Hitung total penjualan per produk dalam 7 hari terakhir
        $salesLast7 = DetailPenjualan::join('penjualan', 'detail_penjualan.id_penjualan', '=', 'penjualan.id_penjualan')
            ->where('penjualan.created_at', '>=', $sevenDaysAgo)
            ->select('detail_penjualan.id_produk', DB::raw('SUM(detail_penjualan.jumlah) as total_qty'))
            ->groupBy('detail_penjualan.id_produk')
            ->pluck('total_qty', 'id_produk');

        // Hitung rata-rata velocity seluruh produk
        $totalVelocity = 0;
        $countWithSales = 0;

        $analyzed = $products->map(function ($product) use ($salesLast30, $salesLast7, &$totalVelocity, &$countWithSales) {
            $soldLast30 = $salesLast30[$product->id_produk] ?? 0;
            $soldLast7  = $salesLast7[$product->id_produk] ?? 0;
            $velocity   = round($soldLast30 / 30, 2); // unit per hari

            if ($velocity > 0) {
                $totalVelocity += $velocity;
                $countWithSales++;
            }

            $daysUntilStockout = $velocity > 0 ? floor($product->stok_produk / $velocity) : null;
            $reorderQty = max(ceil($velocity * 30), 1); // 30 hari supply

            // Klasifikasi risiko
            if ($product->stok_produk <= 0) {
                $riskLevel = 'out';
            } elseif ($product->stok_produk <= $product->stok_minimum) {
                $riskLevel = 'critical';
            } elseif ($daysUntilStockout !== null && $daysUntilStockout <= 7) {
                $riskLevel = 'critical';
            } elseif ($daysUntilStockout !== null && $daysUntilStockout <= 14) {
                $riskLevel = 'warning';
            } else {
                $riskLevel = 'safe';
            }

            return [
                'product'           => $product,
                'sold_30'           => $soldLast30,
                'sold_7'            => $soldLast7,
                'velocity'          => $velocity,
                'days_until_stockout' => $daysUntilStockout,
                'reorder_qty'       => $reorderQty,
                'risk_level'        => $riskLevel,
            ];
        });

        $avgVelocity = $countWithSales > 0 ? $totalVelocity / $countWithSales : 0;

        // Tandai fast mover & slow mover
        $analyzed = $analyzed->map(function ($item) use ($avgVelocity) {
            $item['is_fast_mover'] = $avgVelocity > 0 && $item['velocity'] >= $avgVelocity * 1.5;
            $item['is_slow_mover'] = $item['sold_30'] == 0 && $item['product']->stok_produk > 0;
            return $item;
        });

        // Generate AI rekomendasi (natural language)
        $analyzed = $analyzed->map(function ($item) {
            $item['ai_message'] = $this->generateAiMessage($item);
            return $item;
        });

        // Sort: out dulu, critical, warning, safe
        $riskOrder = ['out' => 0, 'critical' => 1, 'warning' => 2, 'safe' => 3];
        $analyzed = $analyzed->sortBy(fn($i) => $riskOrder[$i['risk_level']]);

        // Statistik ringkasan
        $summary = [
            'total'    => $products->count(),
            'out'      => $analyzed->where('risk_level', 'out')->count(),
            'critical' => $analyzed->where('risk_level', 'critical')->count(),
            'warning'  => $analyzed->where('risk_level', 'warning')->count(),
            'safe'     => $analyzed->where('risk_level', 'safe')->count(),
            'fast'     => $analyzed->where('is_fast_mover', true)->count(),
            'slow'     => $analyzed->where('is_slow_mover', true)->count(),
        ];

        // Top 3 paling kritis untuk widget dashboard
        $topAlerts = $analyzed->filter(fn($i) => in_array($i['risk_level'], ['out', 'critical']))->take(3);

        return view('ai.stock', compact('analyzed', 'summary', 'topAlerts'));
    }

    private function generateAiMessage(array $item): string
    {
        $name = $item['product']->nama_produk;
        $stok = $item['product']->stok_produk;
        $min  = $item['product']->stok_minimum;
        $vel  = $item['velocity'];
        $days = $item['days_until_stockout'];
        $qty  = $item['reorder_qty'];
        $satuan = $item['product']->satuan_terkecil ?? 'pcs';

        if ($item['risk_level'] === 'out') {
            return "⚠️ Stok <strong>{$name}</strong> telah <strong>habis</strong>! AI mendeteksi produk ini tidak dapat dijual. Segera lakukan pembelian stok minimal <strong>{$qty} {$satuan}</strong> untuk memenuhi permintaan.";
        }

        if ($item['risk_level'] === 'critical') {
            if ($stok <= $min) {
                return "🚨 Stok <strong>{$name}</strong> = <strong>{$stok} {$satuan}</strong> sudah berada di bawah batas minimum ({$min} {$satuan}). AI merekomendasikan pembelian <strong>{$qty} {$satuan}</strong> segera untuk mencegah kehabisan.";
            }
            return "🔴 AI memperkirakan stok <strong>{$name}</strong> akan habis dalam <strong>{$days} hari</strong> (kecepatan jual: {$vel}/hari). Rekomendasi: beli <strong>{$qty} {$satuan}</strong> untuk persediaan 30 hari.";
        }

        if ($item['risk_level'] === 'warning') {
            return "🟡 Perhatian: stok <strong>{$name}</strong> diperkirakan habis dalam <strong>{$days} hari</strong>. AI menyarankan mulai rencanakan pembelian <strong>{$qty} {$satuan}</strong> dalam waktu dekat.";
        }

        if ($item['is_fast_mover']) {
            return "🚀 <strong>{$name}</strong> adalah produk <em>fast-moving</em> dengan kecepatan jual <strong>{$vel}/hari</strong>. Stok aman ({$stok} {$satuan}), namun AI menyarankan pantau terus dan siapkan reorder {$qty} {$satuan}.";
        }

        if ($item['is_slow_mover']) {
            return "📦 <strong>{$name}</strong> belum terjual dalam 30 hari terakhir. AI mendeteksi potensi overstock. Pertimbangkan promosi atau penyesuaian harga untuk menggerakkan barang ini.";
        }

        return "✅ Stok <strong>{$name}</strong> dalam kondisi aman ({$stok} {$satuan}). AI tidak mendeteksi risiko signifikan saat ini.";
    }
}
