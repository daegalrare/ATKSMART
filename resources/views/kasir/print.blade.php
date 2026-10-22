<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Belanja - {{ $penjualan->no_invoice }}</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        /* Styling khusus cetak printer thermal */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                color: #000 !important;
            }
            .receipt-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            @page {
                margin: 0;
                size: auto;
            }
        }

        /* Ukuran kertas thermal */
        .paper-58mm {
            width: 58mm;
            max-width: 58mm;
            font-size: 11px;
            line-height: 1.35;
        }

        .paper-80mm {
            width: 80mm;
            max-width: 80mm;
            font-size: 13px;
            line-height: 1.4;
        }

        .font-receipt {
            font-family: 'Courier New', Courier, monospace;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800 flex flex-col items-center {{ request('embedded') ? 'p-1 sm:p-2 bg-transparent justify-start' : 'p-4 sm:p-6' }}">

    @if (!request('embedded'))
    <!-- Top Action Bar (Hanya tampil di layar browser langsung) -->
    <div class="no-print w-full max-w-md bg-white p-4 rounded-2xl shadow-lg border border-slate-200 mb-6 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-slate-600">Lebar Kertas:</span>
            <div class="inline-flex rounded-xl bg-slate-100 p-1 border border-slate-200 text-xs">
                <button type="button" id="btn-58" onclick="setPaperSize('58')" class="px-3 py-1 rounded-lg font-bold transition bg-indigo-600 text-white shadow-xs cursor-pointer">
                    58 mm
                </button>
                <button type="button" id="btn-80" onclick="setPaperSize('80')" class="px-3 py-1 rounded-lg font-bold transition text-slate-600 hover:text-slate-900 cursor-pointer">
                    80 mm
                </button>
            </div>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <button type="button" onclick="window.print()" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-600/30 transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Struk
            </button>
            <button type="button" onclick="window.close()" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
    @endif

    <!-- RECEIPT THERMAL WRAPPER -->
    <div id="receipt-paper" class="receipt-container {{ request('size') === '80' ? 'paper-80mm' : 'paper-58mm' }} font-receipt bg-white p-4 rounded-xl shadow-md border border-slate-200 text-black">
        
        <!-- Header Toko -->
        <div class="text-center pb-2">
            <h1 class="text-base font-black tracking-wider uppercase">ATK SMART</h1>
            <p class="text-[10px] leading-tight mt-0.5">Alat Tulis Kantor & Sekolah</p>
            <p class="text-[9px] leading-tight text-slate-600">Jl. Raya Pendidikan No. 12 &bull; 0812-3456-7890</p>
        </div>

        <!-- Garis Pemisah -->
        <div class="border-b border-dashed border-black my-1.5"></div>

        <!-- Info Transaksi -->
        <div class="space-y-0.5 text-[10px]">
            <div class="flex justify-between">
                <span>No. Nota</span>
                <span class="font-bold">{{ $penjualan->no_invoice }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ $penjualan->tanggal_penjualan ? $penjualan->tanggal_penjualan->format('d/m/Y H:i') : ($penjualan->created_at ? $penjualan->created_at->format('d/m/Y H:i') : '-') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir</span>
                <span>{{ $penjualan->account?->nama_akun ?? 'Kasir' }}</span>
            </div>
        </div>

        <!-- Garis Pemisah -->
        <div class="border-b border-dashed border-black my-1.5"></div>

        <!-- Daftar Item Pembelian -->
        <div class="space-y-2 text-[10px]">
            @php $totalItemCount = 0; @endphp
            @foreach ($penjualan->details as $index => $item)
                @php $totalItemCount += $item->jumlah; @endphp
                <div>
                    <!-- Nama Produk -->
                    <div class="font-bold leading-tight">
                        {{ $item->product?->nama_produk ?? ('Produk #' . $item->id_produk) }}
                    </div>
                    <!-- Qty x Harga Satuan & Subtotal -->
                    <div class="flex justify-between text-[10px] text-slate-800">
                        <span>{{ $item->jumlah }} × {{ number_format($item->harga_jual_saat_ini, 0, ',', '.') }}</span>
                        <span class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Garis Pemisah -->
        <div class="border-b border-dashed border-black my-1.5"></div>

        <!-- Ringkasan Total & Pembayaran -->
        <div class="space-y-1 text-[10px]">
            <div class="flex justify-between">
                <span>Total Item</span>
                <span>{{ $totalItemCount }} pcs</span>
            </div>
            <div class="flex justify-between font-bold text-xs pt-0.5 border-t border-dotted border-black/40">
                <span>TOTAL AKHIR</span>
                <span class="font-black">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tunai / Bayar</span>
                <span>Rp {{ number_format($penjualan->uang_diterima, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold">
                <span>Kembalian</span>
                <span>Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Garis Pemisah -->
        <div class="border-b border-dashed border-black my-2"></div>

        <!-- Catatan Footer -->
        <div class="text-center text-[9px] space-y-1">
            <p class="font-bold">*** TERIMA KASIH ***</p>
            <p class="leading-tight">Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
            <p class="text-[8px] text-slate-500 pt-1">Simpan struk ini sebagai bukti transaksi resmi.</p>
        </div>

        <!-- Visual Barcode Nomor Invoice -->
        <div class="pt-3 pb-1 text-center">
            <div class="inline-flex flex-col items-center">
                <!-- Simple CSS barcode lines effect -->
                <div class="flex items-center justify-center gap-[2px] h-6 overflow-hidden px-2">
                    <span class="w-[2px] h-6 bg-black"></span>
                    <span class="w-[1px] h-6 bg-black"></span>
                    <span class="w-[3px] h-6 bg-black"></span>
                    <span class="w-[1px] h-6 bg-black"></span>
                    <span class="w-[2px] h-6 bg-black"></span>
                    <span class="w-[4px] h-6 bg-black"></span>
                    <span class="w-[1px] h-6 bg-black"></span>
                    <span class="w-[2px] h-6 bg-black"></span>
                    <span class="w-[3px] h-6 bg-black"></span>
                    <span class="w-[1px] h-6 bg-black"></span>
                    <span class="w-[2px] h-6 bg-black"></span>
                    <span class="w-[1px] h-6 bg-black"></span>
                    <span class="w-[4px] h-6 bg-black"></span>
                    <span class="w-[2px] h-6 bg-black"></span>
                    <span class="w-[1px] h-6 bg-black"></span>
                    <span class="w-[3px] h-6 bg-black"></span>
                    <span class="w-[2px] h-6 bg-black"></span>
                </div>
                <span class="text-[8px] font-mono tracking-widest mt-0.5">{{ $penjualan->no_invoice }}</span>
            </div>
        </div>
    </div>

    <!-- Script Kontrol Cetak -->
    <script>
        window.setPaperSize = function(size) {
            const paper = document.getElementById('receipt-paper');
            const btn58 = document.getElementById('btn-58');
            const btn80 = document.getElementById('btn-80');

            if (size === '80') {
                paper.classList.remove('paper-58mm');
                paper.classList.add('paper-80mm');
                if (btn80) {
                    btn80.classList.add('bg-indigo-600', 'text-white', 'shadow-xs');
                    btn80.classList.remove('text-slate-600');
                }
                if (btn58) {
                    btn58.classList.remove('bg-indigo-600', 'text-white', 'shadow-xs');
                    btn58.classList.add('text-slate-600');
                }
            } else {
                paper.classList.remove('paper-80mm');
                paper.classList.add('paper-58mm');
                if (btn58) {
                    btn58.classList.add('bg-indigo-600', 'text-white', 'shadow-xs');
                    btn58.classList.remove('text-slate-600');
                }
                if (btn80) {
                    btn80.classList.remove('bg-indigo-600', 'text-white', 'shadow-xs');
                    btn80.classList.add('text-slate-600');
                }
            }
        };

        window.triggerPrint = function() {
            window.print();
        };

        // Pesan postMessage dari parent window
        window.addEventListener('message', (event) => {
            if (event.data && event.data.action === 'setSize') {
                window.setPaperSize(event.data.size);
            } else if (event.data && event.data.action === 'print') {
                window.print();
            }
        });

        // Auto print jika ada parameter url autoprint=1 dan BUKAN embedded
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('autoprint') === '1' && !urlParams.get('embedded')) {
                setTimeout(() => {
                    window.print();
                }, 400);
            }
        });
    </script>
</body>
</html>
