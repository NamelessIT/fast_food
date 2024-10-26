<div class=" container categoryWrapper mt-5">
    <div class="categoryItems row">
        @foreach ($categoryItems as $item)
            <div class="categoryItem col col-lg-3 col-md-6 col-xs-1  ">
                <a href="" class="d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ 'data:image/png;base64,' . $item->image }}" alt="" class="rounded-circle" >
                    <div class="mt-3 text-center categoryName ">
                        <p class=>{{$item->valueVi}}</p>
                    </div>
                </a>

            </div>
        @endforeach

    </div>
</div>
