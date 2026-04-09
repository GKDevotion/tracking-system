@extends('frontend.layout')

@section('content')

    <!-- BLOG CONTENT -->
    <section class="" style="padding-top: 7rem">
        <div class="container">
            <div class="row g-4">

                <!-- LEFT CONTENT -->
                <div class="col-lg-8">

                    <div class="small mb-2" style="font-size: large;">
                        <a href="{{ url('/') }}" class="text-decoration-none text-dark">Home</a>
                        <span class="mx-1 fs-4">›</span>
                        <a href="{{ route('blog.details', $blog->slug) }}" class="text-decoration-none"
                            style="color: #f73b20;">
                            Blog
                        </a>
                    </div>

                    <h1 class="fw-bold display-6 mt-4">
                        {{ $blog->title }}
                    </h1>

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
                            <span class="btn tag-btn btn-sm rounded-pill" style="border: 1px solid #f73b20">{{ $tag->name }}</span>
                        @endforeach
                    </div>
  

                </div>

                <!-- SIDEBAR -->
                <div class="col-lg-4">

                    <!-- Categories -->
                    <div class="mb-5 mt-2">
                        <h5 class="fw-bold mb-3">Categories</h5>


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
                        <h5 class="fw-bold mb-3">Popular tags</h5>

                        <form method="GET" action="{{ route('news.analysis') }}">
                            <input type="text" name="tag" class="form-control mb-3" placeholder="Search tags..."
                                value="{{ request('tag') }}">
                        </form>

                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($popularTags as $tag)
                                <a href="{{ route('news.analysis', ['tag' => $tag->name]) }}"
                                    class="btn  btn-sm rounded-pill tag-btn" style="border: 1px solid #f73b20; ">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if ($relatedBlogs->count())
                        <section class="py-5 bg-white">
                            <div class="container">
                                <h4 class="fw-bold mb-4">Most Viewed</h4>

                                <div class="list-group list-group-flush">
                                    @foreach ($relatedBlogs as $item)
                                        <a href="{{ route('blog.details', $item->slug) }}"
                                            class="list-group-item list-group-item-action border-0 px-0">

                                            <div class="d-flex gap-3 align-items-center">
                                                <!-- Thumbnail -->
                                                <img src="{{ asset('storage/app/public/' . $item->image) }}"
                                                    alt="{{ $item->title }}" class="rounded"
                                                    style="width: 100px; height: 70px; object-fit: fill;">

                                                <!-- Title -->
                                                <div>
                                                    <h6 class="mb-0   blog-title">
                                                        {{ Str::limit($item->title, 55) }}
                                                    </h6>
                                                </div>
                                            </div>

                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                    
                </div>

            </div>
        </div>
    @endsection
