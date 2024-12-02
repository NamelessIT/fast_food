<div class="details-container-block">
    <div class="listProductContainer  justify-content-center" style="justify-items: center">
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
</div>
