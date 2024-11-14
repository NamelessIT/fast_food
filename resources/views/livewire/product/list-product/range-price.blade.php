<div class="range-price container-fluid p-3 mt-4 rounded-3">
    {{-- {{dd (URL::previous())}} --}}
    <form wire:submit.prevent="handleFilter()" class="d-flex flex-column justify-content-center align-items-center">
        <div class="form-group p-0">
            <input type="number" name="min-price" id="min-price" class="form-control" placeholder="Min Price" wire:model="minPrice">
            @error('minPrice')
                <span class="text-danger mt-2 mx-2">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group mt-3 p-0">
            <input type="number" name="max-price" id="max-price" class="form-control" placeholder="Max Price" wire:model="maxPrice">
            @error('maxPrice')
            <span class="text-danger mt-2 mx-2">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Tìm kiếm</button>
    </form>
</div>
