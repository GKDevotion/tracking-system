<style>

    /* ── Carousel container ── */
    #mainCarousel {
        width: 100%;
        margin-top: 50px;
    }

    .carousel-inner {
        width: 100%;
    }

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

<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">

    <!-- Dot indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">

        <div class="carousel-item active">
            <!-- Replace src with your actual image path -->
            <img src="{{url('storage/app/public/home-slider/website-07.jpg')}}" alt="Our Signals are Money Making Machine" />
        </div>

        <div class="carousel-item">
            <img src="{{url('storage/app/public/home-slider/website-07.jpg')}}" alt="Our Signals are Money Making Machine" />
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
