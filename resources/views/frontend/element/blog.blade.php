<!-- Blog -->
<style>
    /* Section */
    .blog-section {
        padding: 80px 0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        font-weight: 700;
        color: var(--primary-color);
    }

    .section-title p {
        color: #777;
    }

    /* Card */
    .blog-card {
        background: var(--white-color);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s ease;
        position: relative;
        /* border: 1px solid; */
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .blog-card:hover {
        transform: translateY(-10px);
        /* box-shadow: 0 20px 40px rgba(0,0,0,0.1); */
    }

    /* Image */
    .blog-img {
        position: relative;
        overflow: hidden;
    }

    .blog-img img {
        width: 100%;
        transition: transform 0.5s ease;
    }

    .blog-card:hover img {
        transform: scale(1.1);
    }

    /* Overlay */
    .blog-img::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* background: linear-gradient(to top, rgba(0,0,0,0.6), transparent); */
    }

    /* Content */
    .blog-content {
        padding: 20px;
    }

    .blog-content h5 {
        font-weight: 500;
        color: var(--primary-color);
        margin-bottom: 10px;
        min-height: 75px;
    }

    .blog-content p {
        font-size: 14px;
        color: #666;
    }

    /* Read More */
    .read-more {
        font-size: 13px;
        font-weight: 600;
        color: var(--red-color);
        text-decoration: none;
        position: relative;
    }

    .read-more::after {
        content: '';
        width: 0;
        height: 2px;
        background: var(--red-color);
        position: absolute;
        left: 0;
        bottom: -2px;
        transition: 0.3s;
    }

    .read-more:hover::after {
        width: 100%;
    }

    /* Button */
    .see-more-btn {
        display: inline-block;
        padding: 12px 35px;
        border: 1px solid var(--red-color);
        color: var(--red-color);
        border-radius: 5px;
        text-decoration: none;
        transition: 0.3s;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.5);
    }

    .see-more-btn:hover {
        background: var(--red-color);
        color: #fff;
    }
</style>

  <section class="blog-section">
    <div class="container">

        <!-- Title -->
        <div class="section-title">
            <h2>Latest Market Update</h2>
            <p>Check Latest Gold and All forex currency pair news and chart analysis updates</p>
        </div>

        <!-- Blog Grid -->
        <div class="row g-4">

              @forelse ($blogs as $blog)
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6"> 
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="{{ asset('storage/app/public/' . $blog->image) }}" alt="Bitcoin Under Pressure">
                    </div>
                    <div class="blog-content">
                        <h5>
                            {{ $blog->title }}
                        </h5>
                        <p>
                           {{ $blog->short_description }}
                        </p>
                        <a href="{{ route('blog.details', $blog->slug) }}" class="read-more">READ MORE</a>
                    </div>
                </div>
                
            </div>
            @empty
            <div class="col-12">
                <p class="text-center">No blogs available.</p>
            </div>
            @endforelse

        </div>

        <!-- Button -->
        <div class="text-center mt-5">
            <a href="javascript:void(0)" class="see-more-btn">SEE MORE</a>
        </div>

    </div>
</section>