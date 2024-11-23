<div class="details-container-block">
    @if (count ($listProduct) == 0)
        <img src="https://indigosoftwarecompany.com/wp-content/themes/indigo/assets/img/no-product-found.png" alt="" class="img-fluid d-block mx-auto">
    @endif
    <div class="listProductContainer  justify-content-center">
        @foreach ($listProduct as $item)
            <div class="card cardItem">
                @livewire('product.cardproduct', [
                    'id' => $item->id,
                    'product_name' => $item->product_name,
                    'imageShow' => $item->image_show,
                    'price' => $item->price,
                    'slug' => $item->slug
                ])
            </div>
        @endforeach
    </div>
    
    <div wire:loading wire:target="handleAddToCart">
        <x-loader />
    </div>

</div>
