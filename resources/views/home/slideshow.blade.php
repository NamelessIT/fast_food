<div class="slideShowWrapper">
    <div id="carouselFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($slideshowImages as $image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ 'data:image/png;base64,' . $image }}" class="d-block w-100 img-fluid" alt="">
                </div>
            @endforeach

        </div>
        <div class="carousel-indicators">
            @foreach ($slideshowImages as $image)
                <button type="button" data-bs-target="#carouselFade" data-bs-slide-to="{{ $loop->index }}"
                    class="{{ $loop->first ? 'active ' : '' }}rounded-circle" aria-current="true"
                    aria-label="{{ $loop->index + 1 }}"></button>
            @endforeach

        </div>
    </div>
</div>
