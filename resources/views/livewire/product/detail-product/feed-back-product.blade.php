<div class="feed-back-container container mx-auto my-2 d-flex flex-column justify-content-center align-items-center p-3">
    <div class="title mx-auto my-2 fs-3">
        <span>Bình luận</span>
    </div>

    {{-- figure --}}
    <div class="figure-feed-back row w-100 px-5 my-2 d-flex justify-content-center align-items-center rounded">
        {{-- star --}}
        <div class="star col-lg-4 col-md-12 col-sm-12 d-flex flex-column justify-content-center align-items-center">
            <p class="fs-4"><span class="star-current fs-1">4.8</span> trên <span class="startotal fs-3">5</span></p>
            <div class="image-star mb-3">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
        </div>

        {{-- figure --}}
        <div class="figure row col-lg-8 col-md-12 col-sm-12">
            <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                <button>Tất cả</button>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                <button>5 Sao <span>(1,1k)</span></button>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                <button>4 Sao <span>(1,1k)</span></button>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                <button>3 Sao <span>(1,1k)</span></button>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                <button>2 Sao <span>(1,1k)</span></button>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                <button>1 Sao <span>(1,1k)</span></button>
            </div>
        </div>
    </div>

    {{-- list comments --}}
    <div class="list-comment my-3">
        @for ($i = 0; $i < 5; $i++)
            <div class="comment-item row p-2">
                {{-- avatar --}}
                <div class="avatar col-lg-1 col-md-1 col-2">
                    <img src="https://th.bing.com/th/id/OIP.j1rpn-KTUmqcVBQygXuOuQHaIk?rs=1&pid=ImgDetMain"
                        alt="" class="img-fluid rounded-circle p-1 mx-auto d-block">
                </div>

                {{-- description --}}
                <div class="info col-lg-11 col-md-11 col-10">
                    <span class="name mb-2 d-block">Fullname User</span>
                    <div class="star mb-2">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <span class="time mb-3 d-block">2024-11-2 12:41</span>
                    <div class="content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quasi sit excepturi alias
                            aliquid
                            quisquam asperiores, obcaecati quos quod minima quis rem eaque esse dolorum inventore,
                            itaque
                            consequuntur vero ut.</p>
                    </div>
                </div>
            </div>
        @endfor

    </div>
    <div class="btn-show-more">
        <button>Xem Thêm</button>
    </div>
</div>
