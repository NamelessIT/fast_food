<div class="category-navbar d-flex justify-content-center align-items-center">
    @foreach ($categories as $category)
        <div>
            <a class="category-item d-flex flex-column justify-content-center align-items-center splide__slide {{ $category->valueEn == $categoryName ? 'active' : '' }}"
                href="{{ route('category.index', $category->valueEn) }}" wire:navigate>
                <img src="data:image/jpeg;base64, {{ $category->image }}" alt="" class="img-fluid rounded w-75">
                <span>{{ $category->valueVi }}</span>
            </a>
        </div>
    @endforeach
</div>
