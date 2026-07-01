<style>

    /* ── Carousel container ── */
    #mainCarousel {
        width: 100%;
        margin-top: 50px;
    }

    .carousel-inner {
        width: 100%;
    }

    /* .carousel-item{
        height: 95vh;
    } */

    /* ── Each slide is a banner image ── */
    .carousel-item img {
        width: 100%;
        /* height: 420px; */
        object-fit: cover;
        display: block;
    }

    /* ── Responsive heights ── */
    @media (max-width: 991px) {
        .carousel-item img {
            height: 300px;
        }
    }

    @media (max-width: 575px) {
        .carousel-item img {
            height: 200px;
        }
    }

    /* ── Prev / Next buttons ── */
    .carousel-control-prev,
    .carousel-control-next {
        width: 44px;
        height: 44px;
        background: rgba(232, 56, 13, .85);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        transition: background .2s;
    }

    .carousel-control-prev {
        left: 14px;
    }

    .carousel-control-next {
        right: 14px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background: #c42e0b;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 16px;
        height: 16px;
    }

    /* ── Dot indicators ── */
    .carousel-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: none;
        background: #ccc;
        opacity: 1;
        transition: background .2s, transform .2s;
    }

    .carousel-indicators .active {
        background: #E8380D;
        transform: scale(1.3);
    }
</style>
<a href="https://t.me/Wealthoraofficial" target="_blank">
    <div id="mainCarousel"
         class="carousel slide"
         data-bs-ride="carousel"
         data-bs-interval="6000">

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">

            <!-- Video Slide -->
            <div class="carousel-item active">
                <video id="carouselVideo"
                       class="d-block w-100"
                       autoplay
                       muted
                       playsinline
                       preload="auto">
                    <source src="{{ asset('storage/app/public/home-slider/trade-with-verify-signals.mp4') }}" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>

            <!-- Image Slide -->
            <div class="carousel-item">
                <img src="{{ asset('storage/app/public/home-slider/website-07.png') }}"
                     class="d-block w-100"
                     alt="Money Making Machine">
            </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</a>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const carouselElement = document.getElementById('mainCarousel');
    const carousel = new bootstrap.Carousel(carouselElement, {
        interval: 6000,
        ride: 'carousel'
    });

    const video = document.getElementById('carouselVideo');

    carouselElement.addEventListener('slid.bs.carousel', function () {

        const activeSlide = carouselElement.querySelector('.carousel-item.active');

        if (activeSlide.contains(video)) {
            carousel.pause();
            video.currentTime = 0;
            video.playbackRate = 1.0; // 2X Speed
            video.play();
        } else {
            video.pause();
            video.currentTime = 0;
            video.playbackRate = 1.0; // Reset (optional)
            carousel.cycle();
        }

    });

    video.addEventListener('ended', function () {
        carousel.next();
        carousel.cycle();
    });

});
</script>
