<div class=" container categoryWrapper mt-5">
    <div class="categoryItems row row-cols-auto justify-content-center">
        @foreach ($categoryItems as $item)
            <div class="categoryItem col ">
                <a href="{{ route('category.index', ['categoryName' => $item->slug]) }}"
                    class="d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ 'data:image/png;base64,' . $item->image }}" alt="" class="rounded-circle">
                    <div class="mt-3 text-center categoryName ">
                        <p class=>{{ $item->category_name }}</p>
                    </div>
                </a>

            </div>
        @endforeach

    </div>
</div>
