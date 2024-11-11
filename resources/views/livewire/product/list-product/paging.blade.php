<nav aria-label="Page navigation example">
    <ul class="pagination  justify-content-center">
        <li
            @if ($pageCurrent == 1) class="page-item disabled"
            @else
                class="page-item" @endif>
            <a class="page-link" 
            href="{{ route('product.list-product', [
                // 'categoryName' => $categoryName,
                'page' => $pageCurrent-1,
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
                    // 'categoryName' => $categoryName,
                    'page' => $i
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
                // 'categoryName' => $categoryName,
                'page' => $pageCurrent + 1
            ]) }}"
            aria-label="Next" wire:navigate>
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
