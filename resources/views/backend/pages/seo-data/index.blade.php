@extends('layouts.app')

@section('title', 'SEO Data')
@section('page-title', 'SEO Management')

@section('content')

<div class="card border-0 shadow-sm">

    {{-- Card Header --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">

        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-search text-primary"></i>
            <strong>SEO Data List</strong>

            <span class="badge bg-primary rounded-pill">
                {{ $dataArr->total() }}
            </span>
        </div>

        <div class="d-flex gap-2 flex-wrap">

            {{-- Search Form --}}
            <form method="GET" class="d-flex gap-2 flex-wrap">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control form-control-sm"
                       placeholder="Search page slug or title...">

                <input type="date"
                       name="created_at"
                       value="{{ request('created_at') }}"
                       class="form-control form-control-sm">

                <input type="date"
                       name="updated_at"
                       value="{{ request('updated_at') }}"
                       class="form-control form-control-sm">

                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>

                <a href="{{ route('web.seo-data.index') }}"
                   class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-x-circle"></i>
                </a>

            </form>

            {{-- Add Button --}}
            <a href="{{ route('web.seo-data.create') }}"
               class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Add SEO
            </a>

        </div>
    </div>

    {{-- Card Body --}}
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Page Slug</th>
                        <th>Meta Title</th>
                        <th>Meta Description</th>
                        <th>Keywords</th>
                        <th>Status</th>
                        <th width="150">Created</th>
                        <th width="130">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($dataArr as $i => $seo)

                        <tr>

                            <td>
                                {{ $dataArr->firstItem() + $i }}
                            </td>

                            <td>
                                <span class="fw-semibold text-dark">
                                    {{ $seo->page_slug }}
                                </span>
                            </td>

                            <td>
                                {{ Str::limit($seo->meta_title, 40) }}
                            </td>

                            <td>
                                {{ Str::limit(strip_tags($seo->meta_description), 60) }}
                            </td>

                            <td>
                                {{ Str::limit($seo->keywords, 40) }}
                            </td>

                            <td>
                                <span class="badge {{ $seo->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $seo->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td>
                                {{ $seo->created_at?->format('d M Y') }}
                            </td>

                            <td>

                                <div class="d-flex gap-1">

                                    {{-- Edit --}}
                                    <a href="{{ route('web.seo-data.edit', $seo) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('web.seo-data.destroy', $seo) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this SEO data?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                No SEO data found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    @if($dataArr->hasPages())

        <div class="card-footer bg-white">
            {{ $dataArr->links() }}
        </div>

    @endif

</div>

@endsection