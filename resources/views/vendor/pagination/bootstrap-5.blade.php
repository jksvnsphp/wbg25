<style>
    .custom-pagination .page-item .page-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid #2E2B70;
        background-color: transparent;
        color: #2E2B70;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 5px !important;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #2E2B70;
        color: white;
        border-color: #2E2B70;
    }

    .custom-pagination .page-item .page-link:hover {
        background-color: #2E2B70;
        color: white;
    }

    .custom-pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: transparent;
        border-color: #ddd;
    }

    .select-per-page {
        width: auto;
        padding: 5px 10px;
        border-radius: 5px;
        border: 1px solid #2E2B70;
        color: #2E2B70;
        background-color: #fff;
    }
</style>

@if ($paginator->hasPages())
<nav class="d-flex justify-items-center justify-content-between">
    <div class="d-flex justify-content-between flex-fill d-sm-none">
        <ul class="pagination custom-pagination">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
            @else
            <li class="page-item"><a class="page-link"
                    href="{{ $paginator->previousPageUrl() }}&pageItem={{ request('pageItem', 25) }}">&lsaquo;</a>
            </li>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link"
                    href="{{ $paginator->nextPageUrl() }}&pageItem={{ request('pageItem', 25) }}">&rsaquo;</a>
            </li>
            @else
            <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
            @endif
        </ul>
    </div>

    <div
        class="d-none flex-sm-fill d-sm-flex align-items-sm-start justify-content-sm-between flex-column flex-md-row w-100">

        <div class="mb-2 mb-md-0 me-3">
            <ul class="pagination custom-pagination">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                <li class="page-item"><a class="page-link"
                        href="{{ $paginator->previousPageUrl() }}&pageItem={{ request('pageItem', 25) }}">&lsaquo;</a>
                </li>
                @endif

                {{-- Pagination Numbers --}}
                @foreach ($elements as $element)
                @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                @foreach ($element as $page => $url)
                @php $url .= '&pageItem=' . request('pageItem', 25); @endphp
                @if ($page == $paginator->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @elseif (
                $page == $paginator->currentPage() - 1 ||
                $page == $paginator->currentPage() + 1 ||
                $page == 1 ||
                $page == $paginator->lastPage())
                <li class="page-item"><a class="page-link"
                        href="{{ $url }}">{{ $page }}</a></li>
                @elseif ($page == $paginator->currentPage() - 2 || $page == $paginator->currentPage() + 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link"
                        href="{{ $paginator->nextPageUrl() }}&pageItem={{ request('pageItem', 25) }}">&rsaquo;</a>
                </li>
                @else
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif
            </ul>
            <p class="small text-muted text-center">
                Showing <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                to <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                of <span class="fw-semibold">{{ $paginator->total() }}</span> results
            </p>
        </div>

        <div>
            <form method="GET" id="perPageForm" class="d-flex align-items-center">
                <div class="d-flex flex-column">
                    <select name="pageItem" id="perPage" class="select-per-page"
                        onchange="document.getElementById('perPageForm').submit()">
                        @foreach ([25, 50, 100] as $size)
                        <option value="{{ $size }}"
                            {{ request('pageItem', 25) == $size ? 'selected' : '' }}>{{ $size }}
                        </option>
                        @endforeach
                    </select>
                    <label for="pageItem" class="me-2 text-muted small">Items per page:</label>
                </div>
                @foreach (request()->except('pageItem', 'page','order_type') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
            </form>
        </div>

    </div>
</nav>
@endif