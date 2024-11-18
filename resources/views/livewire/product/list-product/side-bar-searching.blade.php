<div class="sideBarSearching d-flex flex-column justify-content-center align-items-center">
    <div class="formWrapper" wire:submit.prevent="handleSearch()">

        {{-- {{dd ($search)}} --}}
        <form>
            <input type="text" name="search" id="searchBarProduct" maxlength="256" placeholder="search here" wire:model="search">
            <button type="submit" class="btn-submit-formSearchProduct">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    @livewire('product.list-product.range-price')

    <div class="containerCategory d-flex flex-column gap-2 my-5 w-100">
        @foreach ($listCategory as $item)
            <div class="w-100">
                <input type="checkbox" class="btn-check" id="category-{{ $item['id'] }}" {{ $item['active'] ? 'checked' : '' }} autocomplete="off">
                <a href="{{ route('product.list-product', [
                    'page' => 1,
                    'category' => $item['slug'],
                    'minPrice' => $item['minPrice'] ?? null,
                    'maxPrice' => $item['maxPrice'] ?? null,
                ]) }}"
                    class="btn btn-outline-primary w-100" for="category-" wire:navigate>{{ $item['category_name'] }}</a>
            </div>
        @endforeach
    </div>
</div>
