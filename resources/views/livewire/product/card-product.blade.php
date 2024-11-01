<div class="card cardItem col ms-3  ">
    <a href="{{ route('product.detail', ['name'=> Str::slug ($product_name), 'id' => $id]) }}">
        <img src="{{ 'data:image/png;base64,' . $imageShow }}" alt="sd"class="img-fluid card-img-top">
    </a>

    <div class="product-content card-body"  style="overflow: hidden">
        <a href="{{ route('product.detail', ['name'=> Str::slug ($product_name), 'id' => $id]) }}" class="content">
            <h5 class="card-title product-name text-center">{{ $product_name }}</h5>
            <p class="card-text product-price text-center">{{ $price }}</p>
        </a>
        <div class="addToCart d-flex justify-content-center flex-column align-items-center ">
            <a href="{{ route('product.detail', ['name'=> Str::slug ($product_name), 'id' => $id]) }}" class="btn btnAddToCart rounded-pill my-3" wire:submit.prevent ="handleAddToCart">
                Add to cart
            </a>
            <div class="w-commerce-commerceaddtocartoutofstock mb-3  d-none ">
                <div class="outOfStock-content" style="cursor: default">this product is out of stock.</div>
            </div>
        </div>
    </div>

</div>
