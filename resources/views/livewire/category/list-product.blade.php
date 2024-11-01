<div class="shopSection" >
    <div class="d-flex main-wrapper ">
        <div class="sideBarSearching d-flex flex-column justify-content-start align-items-start">
            <div class="formWrapper">
                <form action="">
                    <input type="text" name="searchProductValue" id="searchBarProduct" maxlength="256"
                        placeholder="search here">
                    <button type="submit" class="btn-submit-formSearchProduct">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>


            </div>

            <div class="containerCategory d-flex flex-column gap-2 my-5 ">
                <a href="" class="btn">hambuger</a>
                <a href="" class="btn">hambuger</a>
                <a href="" class="btn">hambuger</a>
                <a href="" class="btn">hambuger</a>
                <a href="" class="btn">hambuger</a>

            </div>
        </div>
        <div class="details-container-block">
            <div class="listProductContainer row row-cols-4">
                @foreach ($listProduct as $item)
                    {{-- @livewire('product.card-product') --}}

                    @livewire('product.cardproduct', ['product_name' => $item->product_name, 'imageShow' => $item->image_show, 'price' => $item->price])
                @endforeach
            </div>
        </div>

        <div class="sideBarOnMobile">

        </div>


    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination  justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
