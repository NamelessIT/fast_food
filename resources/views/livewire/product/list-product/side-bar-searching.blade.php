<div class="sideBarSearching d-flex flex-column justify-content-start align-items-start">
    <div class="formWrapper">
        <form action="{{ route('product.list-product', [
            'page' => 1,
            'search' => request('search')
        ]) }}">
            <input type="text" name="search" id="searchBarProduct" maxlength="256" placeholder="search here">
            <button type="submit" class="btn-submit-formSearchProduct">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            @livewire('product.list-product.range-price')
        </form>
    </div>

    <div class="containerCategory d-flex flex-column gap-2 my-5 w-100">
        @foreach ($listCategory as $item)
            <div class="w-100">
                <input type="checkbox" class="btn-check" id="category-{{ $item['id'] }}" {{ $item['active'] ? 'checked' : '' }} autocomplete="off">
                <a href="{{ route('product.list-product', [
                    'page' => 1,
                    'category' => $item['slug'],
                ]) }}"
                    class="btn btn-outline-primary w-100" for="category-" wire:navigate>{{ $item['category_name'] }}</a>
            </div>
        @endforeach
    </div>
</div>
