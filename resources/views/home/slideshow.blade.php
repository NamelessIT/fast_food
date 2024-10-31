<div class="slideShowWrapper">
    <div id="carouselFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($slideshowImages as $image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ 'data:image/png;base64,' . $image }}" class="d-block w-100 " alt="">
                </div>
            @endforeach

        </div>
        {{-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button> --}}


        <div class="carousel-indicators">
            @foreach ($slideshowImages as $image)
                <button type="button" data-bs-target="#carouselFade" data-bs-slide-to="{{ $loop->index }}"
                    class="{{ $loop->first ? 'active ' : '' }}rounded-circle" aria-current="true"
                    aria-label="{{ $loop->index + 1 }}"></button>
            @endforeach

        </div>
    </div>
</div>
