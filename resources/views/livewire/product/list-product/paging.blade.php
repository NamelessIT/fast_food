<nav aria-label="Page navigation example">
    @if ($totalPage != 0)
        <ul class="pagination  justify-content-center">
            <li
                @if ($pageCurrent == 1) class="page-item disabled"
            @else
                class="page-item" @endif>
                <a class="page-link"
                    href="{{ route('product.list-product', [
                        'category' => request()->query('category'),
                        'page' => $pageCurrent - 1,
                        'search' => request()->query('search'),
                        'minPrice' => request()->query('minPrice'),
                        'maxPrice' => request()->query('maxPrice'),
                    ]) }}"
                    aria-label="Previous" wire:navigate>
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for ($i = 1; $i <= $totalPage; $i++)
                <li
                    @if ($pageCurrent == $i) class="page-item active"
            @else
                class="page-item" @endif>
                    <a class="page-link"
                        href="{{ route('product.list-product', [
                            'category' => request()->query('category'),
                            'page' => $i,
                            'search' => request()->query('search'),
                            'minPrice' => request()->query('minPrice'),
                            'maxPrice' => request()->query('maxPrice'),
                        ]) }}"
                        wire:navigate>{{ $i }}</a>
                </li>
            @endfor
            <li
                @if ($pageCurrent == $totalPage) class="page-item disabled"
        @else
            class="page-item" @endif>
                <a class="page-link"
                    href="{{ route('product.list-product', [
                        'category' => request()->query('category'),
                        'page' => $pageCurrent + 1,
                        'search' => request()->query('search'),
                        'minPrice' => request()->query('minPrice'),
                        'maxPrice' => request()->query('maxPrice'),
                    ]) }}"
                    aria-label="Next" wire:navigate>
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    @endif
</nav>
