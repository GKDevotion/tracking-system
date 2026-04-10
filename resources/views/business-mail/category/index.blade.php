@extends('layouts.app')

@section('title', 'Categories')
@section('page-title', 'Category')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Business Mail</a></li>
    <li class="breadcrumb-item active">Category</li>
@endsection
@section('topbar-action')
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#categoryModal">
        <i class="bi bi-plus-lg"></i> Add Category
    </button>
@endsection

@section('content')

    <div class="bm-table">
        {{-- Filter --}}
        <div class="filter-bar">
            <form method="GET" action="{{ route('web.bm-category.index') }}" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" class="form-control" placeholder="Search name..."
                    value="{{ request('search') }}" style="max-width:220px">
                <select name="status" class="form-select" style="max-width:140px">
                    <option value="">All status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Disabled</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('web.bm-category.index') }}" class="btn btn-sm btn-light">Reset</a>
            </form>
        </div>

        {{-- Table --}}
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Templates</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td class="text-muted">{{ $categories->firstItem() + $loop->index }}</td>
                        <td class="fw-medium">{{ $cat->name }}</td>
                        <td><code class="text-muted" style="font-size:.78rem">{{ $cat->slug }}</code></td>
                        <td>
                            <span class="badge bg-light text-secondary border">{{ $cat->templates_count }}</span>
                        </td>
                        <td>
                            <span class="badge rounded-pill {{ $cat->status ? 'badge-enabled' : 'badge-disabled' }}">
                                {{ $cat->status ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $cat->created_at->format('d M Y') }}</td>
                        <td class="text-muted">{{ $cat->updated_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-light btn-edit-cat"
                                    data-id="{{ $cat->id }}" data-name="{{ $cat->name }}"
                                    data-slug="{{ $cat->slug }}" data-status="{{ $cat->status }}"
                                    data-bs-toggle="modal" data-bs-target="#categoryModal">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('web.bm-category.destroy', $cat) }}" method="POST"
                                    onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">No categories found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="bm-pagination">
            <span class="page-info">
                Showing {{ $categories->firstItem() }}–{{ $categories->lastItem() }} of {{ $categories->total() }}
            </span>
            {{ $categories->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- Add / Edit Modal --}}
    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="categoryForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="id" value="0">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalTitle">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="cat_name" class="form-control" required
                                placeholder="e.g. Business Growth">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                Slug
                                <small class="text-muted fw-normal">(auto-generated if empty)</small>
                            </label>
                            <input type="text" name="slug" id="cat_slug" class="form-control"
                                placeholder="business-growth">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Status</label>
                            <select name="status" id="cat_status" class="form-select">
                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="catSubmitBtn">Save Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const addUrl = "{{ route('web.bm-category.store') }}";

        // Auto-generate slug from name
        document.getElementById('cat_name').addEventListener('input', function() {
            if (!document.getElementById('cat_slug').dataset.manual) {
                document.getElementById('cat_slug').value = this.value
                    .toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            }
        });
        document.getElementById('cat_slug').addEventListener('input', function() {
            this.dataset.manual = this.value ? '1' : '';
        });

        // Edit button — fill form
        document.querySelectorAll('.btn-edit-cat').forEach(btn => {
            btn.addEventListener('click', function() {
                // const id = this.dataset.id;
                document.getElementById('categoryModalTitle').textContent = 'Edit Category';
                // document.getElementById('categoryForm').action = `/admin/business-mail/categories/${id}`;
                document.getElementById('id').value = this.dataset.id;
                // document.getElementById('formMethod').value = 'PUT';
                document.getElementById('cat_name').value = this.dataset.name;
                document.getElementById('cat_slug').value = this.dataset.slug;
                document.getElementById('cat_status').value = this.dataset.status;
                document.getElementById('catSubmitBtn').textContent = 'Update Category';
            });
        });

        // Reset on close
        document.getElementById('categoryModal').addEventListener('hidden.bs.modal', () => {
            document.getElementById('categoryModalTitle').textContent = 'Add Category';
            document.getElementById('categoryForm').action = addUrl;
            // document.getElementById('formMethod').value = 'POST';
            document.getElementById('categoryForm').reset();
            document.getElementById('catSubmitBtn').textContent = 'Save Category';
            delete document.getElementById('cat_slug').dataset.manual;
        });
    </script>
@endpush
