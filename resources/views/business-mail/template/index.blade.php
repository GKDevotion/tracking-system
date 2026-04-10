@extends('layouts.app')

@section('title', 'Mail Templates')
@section('page-title', 'Mail Template')
@section('breadcrumb')
    <li class="breadcrumb-item active">Mail Template</li>
@endsection
@section('topbar-action')
    <a href="{{ route('web.bm-mail-template.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Add Template
    </a>
@endsection

@section('content')

    <div class="bm-table">
        <div class="filter-bar">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" class="form-control" placeholder="Search template name..."
                    value="{{ request('search') }}" style="max-width:220px">
                <select name="status" class="form-select" style="max-width:140px">
                    <option value="">All status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Disabled</option>
                </select>
                <select name="category_id" class="form-select" style="max-width:170px">
                    <option value="">All categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('web.bm-mail-template.index') }}" class="btn btn-sm btn-light">Reset</a>
            </form>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Subject</th>
                    <th>Short Description</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $tmpl)
                    <tr>
                        <td class="text-muted">{{ $templates->firstItem() + $loop->index }}</td>
                        <td class="fw-medium">{{ $tmpl->name }}</td>
                        <td>
                            @if ($tmpl->category)
                                <span class="badge badge-bulk rounded-pill">{{ $tmpl->category->name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted"
                            style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $tmpl->subject }}
                        </td>
                        <td class="text-muted"
                            style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $tmpl->short_description ?? '—' }}
                        </td>
                        <td>
                            <span class="badge rounded-pill {{ $tmpl->status ? 'badge-enabled' : 'badge-disabled' }}">
                                {{ $tmpl->status ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $tmpl->created_at->format('d M Y') }}</td>
                        <td class="text-muted">{{ $tmpl->updated_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1 flex-nowrap">
                                {{-- Send --}}
                                <button type="button" class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                    data-bs-target="#sendFromTemplateModal" data-tmpl-id="{{ $tmpl->id }}"
                                    data-tmpl-name="{{ $tmpl->name }}" {{ $tmpl->status == 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-send"></i>
                                </button>
                                {{-- View --}}
                                <a href="{{ route('web.bm-mail-template.show', $tmpl) }}" class="btn btn-sm btn-light"
                                    title="View"><i class="bi bi-eye"></i></a>
                                {{-- Edit --}}
                                <a href="{{ route('web.bm-mail-template.edit', $tmpl) }}" class="btn btn-sm btn-light"
                                    title="Edit"><i class="bi bi-pencil"></i></a>
                                {{-- Delete --}}
                                <form action="{{ route('web.bm-mail-template.destroy', $tmpl) }}" method="POST"
                                    onsubmit="return confirm('Delete this template?')">
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
                        <td colspan="9" class="text-center text-muted py-5">No templates found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="bm-pagination">
            <span class="page-info">Showing {{ $templates->firstItem() }}–{{ $templates->lastItem() }} of
                {{ $templates->total() }}</span>
            {{ $templates->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- Send from template modal --}}
    <div class="modal fade" id="sendFromTemplateModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('web.bm-mail-template.sendToClient') }}">
                @csrf
                <input type="hidden" name="template_id" id="stf_template_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send — <span id="stf_tmpl_name"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Select Client <span class="text-danger">*</span></label>
                            <select name="client_id" class="form-select" required>
                                <option value="">-- Choose client --</option>
                                @foreach ($activeClients as $client)
                                    <option value="{{ $client->id }}">
                                        {{ $client->company_name }} — {{ $client->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-send me-1"></i> Send Mail
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-bs-target="#sendFromTemplateModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('stf_template_id').value = this.dataset.tmplId;
                document.getElementById('stf_tmpl_name').textContent = this.dataset.tmplName;
            });
        });
    </script>
@endpush
