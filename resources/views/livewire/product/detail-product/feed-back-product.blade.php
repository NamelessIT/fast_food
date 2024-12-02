<div class="feed-back-container container mx-auto my-2 d-flex flex-column justify-content-center align-items-center p-3">
    <div class="title mx-auto my-2 fs-3">
        <span>Bình luận</span>
    </div>

    {{-- list comments --}}
    <div class="list-comment my-3 w-100">
        @if (count($listFeedBack) == 0)
            <div class="text-center">
                <p class="text-muted text-uppercase">Chưa có bình luận nào</p>
            </div>
        @else
            @for ($i = 0; $i < count($listFeedBack); $i++)
                <div class="comment-item row p-2">
                    {{-- avatar --}}
                    <div class="avatar col-lg-1 col-md-1 col-2">
                        <img src={{ $listFeedBack[$i]->avatar ? "data:image/png;base64," . $listFeedBack[$i]->avatar : 'https://th.bing.com/th/id/OIP._oHjxcDbPRe0HSQA1B4SygHaHa?w=191&h=191&c=7&r=0&o=5&dpr=1.3&pid=1.7' }}
                            alt="https://th.bing.com/th/id/OIP._oHjxcDbPRe0HSQA1B4SygHaHa?w=191&h=191&c=7&r=0&o=5&dpr=1.3&pid=1.7" class="img-fluid rounded-circle p-1 mx-auto d-block">
                    </div>

                    {{-- description --}}
                    <div class="info col-lg-11 col-md-11 col-10">
                        <span class="name mb-2 d-block">{{ $listFeedBack[$i]->full_name }}</span>
                        <div class="star mb-2">
                            @for ($j = 0; $j < $listFeedBack[$i]->evaluation; $j++)
                                <i class="fa-solid fa-star"></i>                            
                            @endfor
                            @for ($j = 0; $j < 5 - $listFeedBack[$i]->evaluation; $j++)
                                <i class="fa-regular fa-star"></i>
                            @endfor
                        </div>
                        <span class="time mb-3 d-block">{{ Carbon\Carbon::parse($listFeedBack[$i]->created_at)->format('d/m/Y') }}</span>
                        <div class="content">
                            <p>{{ $listFeedBack[$i]->content }}</p>
                        </div>
                    </div>
                </div>
            @endfor

        @endif

    </div>
</div>
