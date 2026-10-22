<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan - ATK SMART ({{ $startDate }} s/d {{ $endDate }})</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        body {
            background-color: #f8fafc;
            color: #0f172a;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .brand-title {
            font-size: 20px;
            font-weight: 800;
            color: #4f46e5;
            margin: 0;
        }
        .brand-subtitle {
            font-size: 11px;
            color: #64748b;
            margin: 4px 0 0 0;
        }
        .report-title {
            text-align: right;
        }
        .report-title h2 {
            margin: 0;
            font-size: 16px;
            color: #0f172a;
        }
        .report-title p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #64748b;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            border-radius: 8px;
        }
        .summary-card span {
            display: block;
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
        }
        .summary-card strong {
            display: block;
            font-size: 14px;
            color: #0f172a;
            margin-top: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        th {
            background: #f1f5f9;
            font-size: 10px;
            text-transform: uppercase;
            color: #475569;
            font-weight: 700;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-mono { font-family: monospace; font-size: 11px; }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-space {
            height: 60px;
        }
        .action-bar {
            max-width: 900px;
            margin: 0 auto 16px auto;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-print { background: #4f46e5; color: white; }
        .btn-close { background: #e2e8f0; color: #475569; }

        @media print {
            body { background: white; padding: 0; }
            .container { box-shadow: none; border-radius: 0; padding: 0; max-width: 100%; }
            .action-bar { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="action-bar">
        <button onclick="window.close()" class="btn btn-close">Tutup</button>
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak Dokumen</button>
    </div>

    <div class="container">
        <!-- HEADER KOP LAPORAN -->
        <div class="header">
            <div>
                <h1 class="brand-title">ATK SMART</h1>
                <p class="brand-subtitle">Sistem Informasi Kasir & Manajemen Stok ATK</p>
                <p class="brand-subtitle">Tanggal Cetak: {{ date('d F Y, H:i') }} WIB</p>
            </div>
            <div class="report-title">
                <h2>LAPORAN KEUANGAN & LABA RUGI</h2>
                <p>Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong></p>
            </div>
        </div>

        <!-- RINGKASAN FINANSIAL -->
        <div class="summary-grid">
            <div class="summary-card">
                <span>Total Omzet Penjualan</span>
                <strong>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</strong>
            </div>
            <div class="summary-card">
                <span>Modal Pokok (HPP)</span>
                <strong>Rp {{ number_format($totalHpp, 0, ',', '.') }}</strong>
            </div>
            <div class="summary-card" style="background: #eef2ff; border-color: #c7d2fe;">
                <span style="color: #4f46e5;">Laba Kotor (Gross Profit)</span>
                <strong style="color: #3730a3;">Rp {{ number_format($labaKotor, 0, ',', '.') }}</strong>
            </div>
            <div class="summary-card" style="background: #f0fdf4; border-color: #bbf7d0;">
                <span style="color: #166534;">Estimasi Laba Bersih</span>
                <strong style="color: #14532d;">Rp {{ number_format($labaBersihEstimasi, 0, ',', '.') }}</strong>
            </div>
        </div>

        <!-- RINCIAN TRANSAKSI PENJUALAN -->
        <h3 style="font-size: 13px; font-weight: 700; margin-bottom: 8px; color: #1e293b;">1. Rincian Penjualan & Laba per Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 130px;">No Invoice</th>
                    <th>Waktu</th>
                    <th>Kasir</th>
                    <th class="text-right">Omzet</th>
                    <th class="text-right">Modal (HPP)</th>
                    <th class="text-right">Laba Kotor</th>
                    <th class="text-center">Margin</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualanList as $item)
                    @php
                        $omzet = (float) $item->total_bayar;
                        $hpp = $item->details->sum(fn ($d) => $d->jumlah * ($d->harga_beli_saat_ini ?? 0));
                        $laba = $omzet - $hpp;
                        $margin = $omzet > 0 ? round(($laba / $omzet) * 100, 1) : 0;
                    @endphp
                    <tr>
                        <td class="font-mono font-bold">{{ $item->no_invoice }}</td>
                        <td>{{ $item->tanggal_penjualan ? $item->tanggal_penjualan->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $item->account->nama_akun ?? 'Administrator' }}</td>
                        <td class="text-right">Rp {{ number_format($omzet, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($hpp, 0, ',', '.') }}</td>
                        <td class="text-right" style="font-weight: 700; color: #16a34a;">Rp {{ number_format($laba, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $margin }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="color: #94a3b8; padding: 16px;">
                            Tidak ada transaksi penjualan pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="font-weight: 700; background: #f8fafc;">
                    <td colspan="3" class="text-right">TOTAL</td>
                    <td class="text-right">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalHpp, 0, ',', '.') }}</td>
                    <td class="text-right" style="color: #16a34a;">Rp {{ number_format($labaKotor, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $totalOmzet > 0 ? round(($labaKotor / $totalOmzet) * 100, 1) : 0 }}%</td>
                </tr>
            </tfoot>
        </table>

        <!-- RINCIAN PENGELUARAN PEMBELIAN STOK -->
        <h3 style="font-size: 13px; font-weight: 700; margin-bottom: 8px; color: #1e293b; margin-top: 24px;">2. Ringkasan Pengeluaran Pembelian Stok (Kulakan)</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Produk</th>
                    <th class="text-center">Jumlah Masuk</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Total Biaya</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembelianList as $beli)
                    <tr>
                        <td>{{ $beli->tanggal_masuk ? \Carbon\Carbon::parse($beli->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $beli->product->nama_produk ?? 'Produk Dihapus' }}</td>
                        <td class="text-center">+{{ number_format($beli->jumlah_barang_masuk) }} {{ $beli->product->satuan_terkecil ?? 'unit' }}</td>
                        <td class="text-right">Rp {{ number_format($beli->harga_beli_satuan, 0, ',', '.') }}</td>
                        <td class="text-right" style="font-weight: 600;">Rp {{ number_format($beli->total_harga_beli, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="color: #94a3b8; padding: 12px;">
                            Tidak ada pengeluaran pembelian stok pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="font-weight: 700; background: #f8fafc;">
                    <td colspan="4" class="text-right">TOTAL PENGELUARAN PEMBELIAN</td>
                    <td class="text-right">Rp {{ number_format($totalPembelian, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- TANDA TANGAN -->
        <div class="signatures">
            <div class="signature-box">
                <p style="margin: 0; color: #64748b;">Dibuat Oleh:</p>
                <div class="signature-space"></div>
                <p style="margin: 0; font-weight: 700; border-top: 1px solid #cbd5e1; padding-top: 4px;">{{ session('account_name', 'Kasir / Admin') }}</p>
                <p style="margin: 2px 0 0 0; font-size: 10px; color: #64748b;">Petugas Operasional</p>
            </div>
            <div class="signature-box">
                <p style="margin: 0; color: #64748b;">Disetujui Oleh:</p>
                <div class="signature-space"></div>
                <p style="margin: 0; font-weight: 700; border-top: 1px solid #cbd5e1; padding-top: 4px;">Pimpinan / Owner</p>
                <p style="margin: 2px 0 0 0; font-size: 10px; color: #64748b;">Pemilik Toko ATK SMART</p>
            </div>
        </div>
    </div>

</body>
</html>
