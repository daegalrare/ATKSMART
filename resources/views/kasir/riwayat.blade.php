<x-layout>
    <x-slot:title>Riwayat Penjualan</x-slot:title>

    <div class="space-y-6">
        <!-- Header & Action Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Riwayat Penjualan</h1>
                <p class="text-sm text-slate-500 mt-1">Daftar rekaman transaksi penjualan langsung ke customer.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('kasir.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-500/20 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="8" cy="21" r="1"/>
                        <circle cx="19" cy="21" r="1"/>
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                    </svg>
                    Buka Kasir POS
                </a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-50/50">
                <div class="relative w-full sm:w-72">
                    <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        id="search-input"
                        placeholder="Cari no invoice..."
                        class="w-full pl-9 pr-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs placeholder:text-slate-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition"
                    >
                </div>
                <div class="text-xs text-slate-500 font-medium">
                    Total: <span class="font-bold text-slate-800">{{ $riwayat->total() }}</span> Transaksi
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 uppercase tracking-wider font-semibold text-[10px] bg-slate-50/70">
                            <th class="px-5 py-3.5">No. Invoice</th>
                            <th class="px-5 py-3.5">Waktu Transaksi</th>
                            <th class="px-5 py-3.5">Kasir</th>
                            <th class="px-5 py-3.5 text-center">Jumlah Item</th>
                            <th class="px-5 py-3.5 text-right">Total Bayar</th>
                            <th class="px-5 py-3.5 text-right">Uang Diterima</th>
                            <th class="px-5 py-3.5 text-right">Kembalian</th>
                            <th class="px-5 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700" id="transaction-rows">
                        @forelse ($riwayat as $p)
                            <tr class="hover:bg-slate-50/70 transition-colors transaction-row" data-invoice="{{ strtolower($p->no_invoice) }}">
                                <td class="px-5 py-4 font-mono font-bold text-indigo-600">
                                    {{ $p->no_invoice }}
                                </td>
                                <td class="px-5 py-4 text-slate-500">
                                    {{ $p->created_at ? $p->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold text-[11px]">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $p->account?->nama_akun ?? 'Kasir' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center font-semibold">
                                    {{ $p->details->sum('jumlah') }} pcs ({{ $p->details->count() }} varian)
                                </td>
                                <td class="px-5 py-4 text-right font-extrabold text-slate-900">
                                    Rp {{ number_format($p->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-right text-emerald-600 font-semibold">
                                    Rp {{ number_format($p->uang_diterima, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-right text-slate-600">
                                    Rp {{ number_format($p->kembalian, 0, ',', '.') }}
                                </td>
                                 <td class="px-5 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button
                                            type="button"
                                            onclick="viewInvoiceDetail(@js($p))"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 text-indigo-600 font-semibold text-xs transition cursor-pointer"
                                            title="Lihat Detail Transaksi"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detail
                                        </button>
                                        <button
                                            type="button"
                                            onclick="printStrukDirect('{{ $p->id_penjualan }}', '{{ $p->no_invoice }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs transition cursor-pointer shadow-xs"
                                            title="Cetak Struk Thermal"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                            </svg>
                                            Cetak
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-slate-400">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                    <p class="font-semibold text-slate-600">Belum ada transaksi penjualan</p>
                                    <p class="text-xs mt-1 text-slate-400">Transaksi baru dari kasir akan tercatat di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($riwayat->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $riwayat->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MODAL DETAIL TRANSAKSI                       -->
    <!-- ============================================ -->
    <div id="modal-detail" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden flex flex-col border border-slate-200">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Detail Transaksi</h4>
                        <p id="detail-no-invoice" class="text-xs font-mono text-indigo-600 font-semibold"></p>
                    </div>
                </div>
                <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body (Printable area) -->
            <div id="print-area" class="p-6 space-y-4 overflow-y-auto max-h-[70vh]">
                <div class="text-center pb-3 border-b border-slate-100">
                    <h3 class="font-extrabold text-base text-slate-800 uppercase tracking-wide">ATK SMART</h3>
                    <p class="text-xs text-slate-500">Struk Pembelian Pelanggan</p>
                    <p id="detail-date" class="text-[11px] text-slate-400 mt-1"></p>
                </div>

                <!-- Item list -->
                <div class="space-y-2 border-b border-slate-100 pb-3" id="detail-items-list">
                    <!-- items injected here -->
                </div>

                <!-- Totals -->
                <div class="space-y-1.5 text-xs text-slate-600">
                    <div class="flex justify-between font-bold text-slate-800 text-sm pt-1">
                        <span>Total Bayar</span>
                        <span id="detail-total" class="text-indigo-600"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Uang Diterima</span>
                        <span id="detail-diterima" class="font-semibold text-slate-800"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Kembalian</span>
                        <span id="detail-kembalian" class="font-semibold text-emerald-600"></span>
                    </div>
                </div>

                <div class="text-center pt-2 text-[11px] text-slate-400">
                    <p>Terima kasih atas kunjungan Anda!</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex gap-2">
                <button type="button" onclick="printCurrentDetail()" class="flex-1 py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold flex items-center justify-center gap-2 transition cursor-pointer shadow-md shadow-indigo-600/30">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Struk Thermal
                </button>
                <button type="button" onclick="closeDetailModal()" class="py-2.5 px-5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ================================================ -->
    <!-- MODAL POP-OUT CETAK STRUK & PILIH UKURAN        -->
    <!-- ================================================ -->
    <div id="modal-print-popout" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 hidden" role="dialog">
        <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity" onclick="closePrintPopout()"></div>
        
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl z-10 overflow-hidden flex flex-col max-h-[92vh] border border-slate-200">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Cetak Struk Transaksi</h3>
                        <p id="popout-invoice-label" class="text-xs font-mono text-indigo-600 font-semibold"></p>
                    </div>
                </div>
                <button type="button" onclick="closePrintPopout()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200/60 flex items-center justify-center transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Toolbar Pilih Ukuran Kertas -->
            <div class="p-4 bg-slate-50/80 border-b border-slate-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-slate-700">1. Pilih Ukuran Kertas Thermal:</span>
                    <span class="text-[11px] font-semibold text-indigo-600" id="paper-size-indicator">Ukuran Aktif: 58 mm</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <!-- Tombol 58mm -->
                    <button type="button" onclick="selectPopoutSize('58')" id="popout-btn-58" class="flex items-center gap-2.5 p-3 rounded-2xl border-2 border-indigo-600 bg-white text-indigo-950 font-semibold text-xs shadow-xs transition cursor-pointer">
                        <div class="w-4 h-4 rounded-full border-2 border-indigo-600 flex items-center justify-center shrink-0">
                            <span class="w-2 h-2 rounded-full bg-indigo-600" id="popout-dot-58"></span>
                        </div>
                        <div class="text-left">
                            <p class="font-bold">58 mm (Standar)</p>
                            <p class="text-[10px] text-slate-500 font-normal">Printer Thermal Mini / Kasir</p>
                        </div>
                    </button>

                    <!-- Tombol 80mm -->
                    <button type="button" onclick="selectPopoutSize('80')" id="popout-btn-80" class="flex items-center gap-2.5 p-3 rounded-2xl border-2 border-slate-200 bg-slate-50 text-slate-700 font-semibold text-xs transition cursor-pointer hover:bg-white">
                        <div class="w-4 h-4 rounded-full border-2 border-slate-300 flex items-center justify-center shrink-0">
                            <span class="w-2 h-2 rounded-full bg-transparent" id="popout-dot-80"></span>
                        </div>
                        <div class="text-left">
                            <p class="font-bold">80 mm (Lebar)</p>
                            <p class="text-[10px] text-slate-500 font-normal">Printer Thermal Lebar POS</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Pratinjau Kertas Struk (Iframe) -->
            <div class="p-4 flex-1 overflow-y-auto bg-slate-100/70 flex flex-col items-center justify-start min-h-[320px]">
                <p class="text-[11px] font-semibold text-slate-500 mb-2">2. Pratinjau Tampilan Struk:</p>
                <div class="w-full bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex justify-center p-2">
                    <iframe id="popout-print-iframe" class="w-full h-[320px] border-0" src="about:blank"></iframe>
                </div>
            </div>

            <!-- Modal Footer (Kolom Cetak Struk) -->
            <div class="p-4 bg-white border-t border-slate-200 flex items-center justify-between gap-3">
                <button type="button" onclick="closePrintPopout()" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="button" onclick="executePrint()" id="btn-execute-print" class="flex-1 py-3 px-5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-600/30 flex items-center justify-center gap-2 transition cursor-pointer hover:scale-[1.01] active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span id="btn-execute-print-label">Cetak Struk Sekarang (58 mm)</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentModalSaleId = null;
        let popoutSaleId = null;
        let selectedPaperSize = '58';

        function rp(num) {
            return 'Rp ' + Number(num || 0).toLocaleString('id-ID');
        }

        function printStrukDirect(id, invoiceNo = '') {
            popoutSaleId = id;
            selectedPaperSize = '58';
            document.getElementById('popout-invoice-label').textContent = invoiceNo || '';
            
            // Set initial button states
            updatePaperSizeUI('58');

            // Load iframe
            const iframe = document.getElementById('popout-print-iframe');
            iframe.src = `{{ url('/kasir/print') }}/${id}?embedded=1&size=58`;

            // Show popout modal
            document.getElementById('modal-print-popout').classList.remove('hidden');
        }

        function closePrintPopout() {
            document.getElementById('modal-print-popout').classList.add('hidden');
            const iframe = document.getElementById('popout-print-iframe');
            iframe.src = 'about:blank';
        }

        function selectPopoutSize(size) {
            selectedPaperSize = size;
            updatePaperSizeUI(size);

            const iframe = document.getElementById('popout-print-iframe');
            if (iframe && iframe.contentWindow) {
                if (typeof iframe.contentWindow.setPaperSize === 'function') {
                    iframe.contentWindow.setPaperSize(size);
                } else {
                    iframe.contentWindow.postMessage({ action: 'setSize', size: size }, '*');
                }
            }
        }

        function updatePaperSizeUI(size) {
            const btn58 = document.getElementById('popout-btn-58');
            const btn80 = document.getElementById('popout-btn-80');
            const dot58 = document.getElementById('popout-dot-58');
            const dot80 = document.getElementById('popout-dot-80');
            const indicator = document.getElementById('paper-size-indicator');
            const btnLabel = document.getElementById('btn-execute-print-label');

            if (size === '80') {
                btn80.className = 'flex items-center gap-2.5 p-3 rounded-2xl border-2 border-indigo-600 bg-white text-indigo-950 font-semibold text-xs shadow-xs transition cursor-pointer';
                dot80.className = 'w-2 h-2 rounded-full bg-indigo-600';
                btn80.querySelector('div').className = 'w-4 h-4 rounded-full border-2 border-indigo-600 flex items-center justify-center shrink-0';

                btn58.className = 'flex items-center gap-2.5 p-3 rounded-2xl border-2 border-slate-200 bg-slate-50 text-slate-700 font-semibold text-xs transition cursor-pointer hover:bg-white';
                dot58.className = 'w-2 h-2 rounded-full bg-transparent';
                btn58.querySelector('div').className = 'w-4 h-4 rounded-full border-2 border-slate-300 flex items-center justify-center shrink-0';

                indicator.textContent = 'Ukuran Aktif: 80 mm';
                btnLabel.textContent = 'Cetak Struk Sekarang (80 mm)';
            } else {
                btn58.className = 'flex items-center gap-2.5 p-3 rounded-2xl border-2 border-indigo-600 bg-white text-indigo-950 font-semibold text-xs shadow-xs transition cursor-pointer';
                dot58.className = 'w-2 h-2 rounded-full bg-indigo-600';
                btn58.querySelector('div').className = 'w-4 h-4 rounded-full border-2 border-indigo-600 flex items-center justify-center shrink-0';

                btn80.className = 'flex items-center gap-2.5 p-3 rounded-2xl border-2 border-slate-200 bg-slate-50 text-slate-700 font-semibold text-xs transition cursor-pointer hover:bg-white';
                dot80.className = 'w-2 h-2 rounded-full bg-transparent';
                btn80.querySelector('div').className = 'w-4 h-4 rounded-full border-2 border-slate-300 flex items-center justify-center shrink-0';

                indicator.textContent = 'Ukuran Aktif: 58 mm';
                btnLabel.textContent = 'Cetak Struk Sekarang (58 mm)';
            }
        }

        function executePrint() {
            const iframe = document.getElementById('popout-print-iframe');
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }
        }

        function printCurrentDetail() {
            if (currentModalSaleId) {
                const invoiceNo = document.getElementById('detail-no-invoice').textContent;
                closeDetailModal();
                printStrukDirect(currentModalSaleId, invoiceNo);
            }
        }

        function viewInvoiceDetail(data) {
            currentModalSaleId = data.id_penjualan || data.no_invoice;
            document.getElementById('detail-no-invoice').textContent = data.no_invoice;
            const dateStr = data.created_at ? new Date(data.created_at).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }) : '-';
            document.getElementById('detail-date').textContent = dateStr;
            document.getElementById('detail-total').textContent = rp(data.total_bayar);
            document.getElementById('detail-diterima').textContent = rp(data.uang_diterima);
            document.getElementById('detail-kembalian').textContent = rp(data.kembalian);

            const itemsHtml = (data.details || []).map(item => {
                const prodName = item.product ? item.product.nama_produk : 'Produk #' + item.id_produk;
                return `
                    <div class="flex justify-between items-start text-xs">
                        <div>
                            <p class="font-semibold text-slate-800">${prodName}</p>
                            <p class="text-[10px] text-slate-400">${item.jumlah} × ${rp(item.harga_jual_saat_ini)}</p>
                        </div>
                        <span class="font-bold text-slate-800">${rp(item.subtotal)}</span>
                    </div>
                `;
            }).join('');

            document.getElementById('detail-items-list').innerHTML = itemsHtml || '<p class="text-xs text-slate-400 text-center">Tidak ada item detail</p>';
            document.getElementById('modal-detail').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('modal-detail').classList.add('hidden');
        }

        // Live filter invoice by search input
        document.getElementById('search-input').addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.transaction-row').forEach(row => {
                const invoice = row.getAttribute('data-invoice') || '';
                row.style.display = invoice.includes(query) ? '' : 'none';
            });
        });
    </script>
</x-layout>
