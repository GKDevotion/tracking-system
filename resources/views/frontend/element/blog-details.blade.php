@extends('frontend.layout')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@section('content')
    <style>
        .blog-cover {
            width: 100%;
            height: 420px;
            /* fixed height */
            object-fit: fill;
            /* keeps aspect ratio */
            object-position: center;
        }

        .share-buttons .share-btn {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #aa8038;
            color: #fff;
            border-radius: 50%;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(170, 128, 56, 0.35);
        }

        .share-buttons .share-btn:hover {
            background-color: #8f6a2e;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(170, 128, 56, 0.55);
            color: #fff;
        }

        .share-buttons .share-btn i {
            line-height: 1;
        }
    </style>

    <!-- BLOG CONTENT -->
    <section class="" style="padding-top: 7rem">
        <div class="container">
            <div class="row g-4">

                <!-- LEFT CONTENT -->
                <div class="col-lg-8">

                    <div class="small mb-2" style="font-size: large;">
                        <a href="{{ url('/') }}" class="text-decoration-none text-dark">Home</a>
                        <span class="mx-1 fs-4">›</span>
                        <a href="{{ route('news.analysis') }}" class="text-decoration-none text-dark">
                            Blog
                        </a>
                    </div>

                    <h2 class="fw-bold text-dark mt-4">
                        {{ $blog->title }}
                    </h2>

                    <div class="d-flex gap-3 text-muted small mt-3 mb-3 fs-6">
                        <span>
                            <i class="bi bi-tag"></i>
                            @if ($blog->category)
                                @if ($blog->category->parent)
                                    {{ $blog->category->parent->title }} › {{ $blog->category->title }}
                                @else
                                    {{ $blog->category->title }}
                                @endif
                            @endif
                        </span>

                        <span>
                            <i class="bi bi-calendar"></i>
                            {{ $blog->created_at->format('d-m-Y') }}
                        </span>
                    </div>

                    <img src="{{ asset('storage/app/public/' . $blog->image) }}" class="img-fluid rounded mb-4 blog-cover"
                        alt="{{ $blog->title }}">

                    <!-- Short Description -->
                    <p class="text-muted fst-italic mb-4">
                        {!! $blog->short_description !!}
                    </p>

                    <!-- HR Line -->
                    <hr class="blog-divider">

                    <div class="blog-content lh-lg fs-6 mb-3">
                        {!! $blog->description !!}
                    </div>

                    <div class="tag-section mb-5">

                        @foreach ($blog->tags as $tag)
                            <span class="btn tag-btn btn-sm rounded-pill"
                                style="border: 1px solid black">{{ $tag->name }}</span>
                        @endforeach
                    </div>


                </div>

                <!-- SIDEBAR -->
                <div class="col-lg-4">

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

                    @if ($relatedBlogs->count())
                        <div class="mt-5">
                            <h5 class="fw-bold text-dark mb-3">Most Viewed</h5>

                            <div class="list-group list-group-flush">
                                @foreach ($relatedBlogs as $item)
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
    @endsection
