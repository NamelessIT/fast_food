<div class="category-navbar d-flex justify-content-center align-items-center">
    @foreach ($categories as $category)
        <div>
            <a class="category-item d-flex flex-column justify-content-center align-items-center splide__slide {{ $category->slug == $categoryName ? 'active' : '' }}"
                href="{{ route('category.index', [
                    'categoryName' => $category->slug,
                    'page' => 1
                ]) }}" wire:navigate>
                <img src="data:image/jpeg;base64, {{ $category->image }}" alt="" class="img-fluid rounded w-75">
                <span>{{ $category->category_name }}</span>
            </a>
        </div>
    @endforeach
</div>
