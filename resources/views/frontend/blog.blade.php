@extends('frontend.layout')
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@section('content')
    <style>
        /* Section */
        .news-analysis-section {
            padding: 150px 0;
        }

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

        /* Fix for blog card content overflow */
        .blog-content h5 a {
            font-weight: 500;
            color: var(--primary-color);
            min-height: 60px;

            /* ADD THESE */
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }


        .blog-content h5 a:hover{
            color: #f73b20;
        }

        .blog-content p {
            font-size: 14px;
            color: #666;

            /* ADD THESE */
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Also fix the card image height */
        .blog-img img {
            width: 100%;
            height: 200px;
            /* ADD THIS */
            object-fit: cover;
            /* ADD THIS */
            transition: transform 0.5s ease;
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

    <section class="news-analysis-section">
        <div class="container">
            <div class="row">

                <div class="col-12 col-md-9">
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
                                        <img src="{{ asset('storage/app/public/' . $blog->image) }}"
                                            alt="Bitcoin Under Pressure">
                                    </div>
                                    <div class="blog-content">
                                        <h5>
                                            <a href="{{ route('blog.details', $blog->slug) }}">{{ $blog->title }}</a>
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

                <div class="col-12 col-md-3">
                    <!-- Categories -->
                    <div class="mb-5 mt-2">
                        <h5 class="fw-bold text-dark mb-3">Categories</h5>

                        <form action="{{ route('news.analysis') }}" method="GET">
                            <div class="input-group mb-4 border">
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="Search categories...">
                                <button class="btn border-0" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>

                        <ul class="list-group list-group-flush">
                            @foreach ($categories as $parent)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('news.analysis', ['category' => $parent->id]) }}"
                                        class="text-decoration-none {{ request('category') == $parent->id ? 'fw-bold text-primary' : 'text-dark' }}">
                                        {{ $parent->title }}
                                    </a>
                                    <i class="bi bi-arrow-right"></i>
                                </li>
                            @endforeach
                        </ul>


                    </div>

                    <!-- Popular Tags -->
                    <div>
                        <h5 class="fw-bold text-dark mb-3">Popular tags</h5>

                        <form method="GET" action="{{ route('news.analysis') }}">
                            <input type="text" name="tag" class="form-control mb-3" placeholder="Search tags..."
                                value="{{ request('tag') }}">
                        </form>

                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($popularTags as $tag)
                                <a href="{{ route('news.analysis', ['tag' => $tag->name]) }}"
                                    class="btn  btn-sm rounded-pill tag-btn" style="border: 1px solid black; ">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if ($recentBlogs->count())
                        <div class="mt-5">
                            <h5 class="fw-bold mb-3 text-dark">Most Viewed</h5>

                            <div class="list-group list-group-flush">
                                @foreach ($recentBlogs as $item)
                                    <a href="{{ route('blog.details', $item->slug) }}"
                                        class="list-group-item list-group-item-action border-0 px-0 text-decoration-none">

                                        <div class="d-flex gap-3 align-items-center mb-2">
                                            <img src="{{ asset('storage/app/public/' . $item->image) }}"
                                                alt="{{ $item->title }}" class="rounded flex-shrink-0"
                                                style="width: 80px; height: 60px; object-fit: cover;">

                                            <h6 class="mb-0 text-dark fw-500"
                                                style="font-size: 13px; line-height: 1.4; word-break: break-word;">
                                                {{ Str::limit($item->title, 55) }}
                                            </h6>
                                        </div>

                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>
@endsection
