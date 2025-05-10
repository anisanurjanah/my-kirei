@if ($paginator->hasPages())
    <nav>
        <ul class="pagination pagination-sm justify-content-end">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link text-danger border-0">Sebelumnya</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link text-danger border-0" href="{{ $paginator->previousPageUrl() }}" rel="prev">Sebelumnya</a>
                </li>
            @endif

            {{-- Logika Pagination --}}
            @php
                $lastPage = $paginator->lastPage(); // Halaman terakhir berdasarkan total data
            @endphp

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link text-danger border-0">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page <= 3 || $page == $lastPage)
                            {{-- Tampilkan halaman 1, 2, 3 dan terakhir --}}
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <span class="page-link bg-danger text-white border-0">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link text-danger border-0" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @elseif ($page == 4)
                            {{-- Tambahkan titik-titik (...) setelah halaman 3 --}}
                            <li class="page-item disabled">
                                <span class="page-link text-danger border-0">...</span>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Berikutnya --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link text-danger border-0" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link text-danger border-0">Berikutnya</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
