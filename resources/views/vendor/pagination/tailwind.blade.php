@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
        {{-- Info Hasil (Tampil di desktop dan mobile) --}}
        <div class="text-slate-500 font-medium text-center sm:text-left">
            Menampilkan
            @if ($paginator->firstItem())
                <span class="font-bold text-slate-800">{{ $paginator->firstItem() }}</span>
                sampai
                <span class="font-bold text-slate-800">{{ $paginator->lastItem() }}</span>
            @else
                <span class="font-bold text-slate-800">{{ $paginator->count() }}</span>
            @endif
            dari
            <span class="font-bold text-slate-800">{{ $paginator->total() }}</span>
            data
        </div>

        {{-- Navigasi Tombol Angka --}}
        <div class="flex items-center gap-1.5">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="Sebelumnya" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl border border-slate-200/80 bg-slate-50 text-slate-300 flex items-center justify-center cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl border border-slate-200/80 bg-white hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 text-slate-600 flex items-center justify-center transition shadow-xs cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            @endif

            {{-- Elemen Nomor Halaman --}}
            @foreach ($elements as $element)
                {{-- Pemisah Tiga Titik (...) --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="w-8 h-8 sm:w-9 sm:h-9 text-slate-400 font-semibold flex items-center justify-center">
                        {{ $element }}
                    </span>
                @endif

                {{-- Nomor Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-xs shadow-indigo-500/25">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl border border-slate-200/80 bg-white hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 text-slate-700 font-semibold text-xs flex items-center justify-center transition shadow-xs cursor-pointer" aria-label="Ke halaman {{ $page }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Berikutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl border border-slate-200/80 bg-white hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 text-slate-600 flex items-center justify-center transition shadow-xs cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span aria-disabled="true" aria-label="Berikutnya" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl border border-slate-200/80 bg-slate-50 text-slate-300 flex items-center justify-center cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
