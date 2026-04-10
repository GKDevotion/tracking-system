@extends('layouts.app')

@section('title', 'Clients')
@section('page-title', 'Clients')
@section('breadcrumb')
    <li class="breadcrumb-item active">Clients</li>
@endsection
@section('topbar-action')
    <button class="btn btn-sm" style="background:#ede9fe;color:#5b21b6;border:1px solid #c4b5fd" data-bs-toggle="modal"
        data-bs-target="#bulkMailModal">
        <i class="bi bi-send-fill me-1"></i> Bulk Mail Campaign
    </button>
    <a href="{{ route('web.bm-client.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Add Client
    </a>
@endsection

@section('content')

    <div class="bm-table">
        {{-- Filter bar --}}
        <div class="filter-bar">
            <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                <input type="text" name="search" class="form-control" placeholder="Search name, company, email..."
                    value="{{ request('search') }}" style="max-width:240px">
                <select name="status" class="form-select" style="max-width:130px">
                    <option value="">All status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Disabled</option>
                </select>
                <select name="sent" class="form-select" style="max-width:130px">
                    <option value="">All sent</option>
                    <option value="1" {{ request('sent') == '1' ? 'selected' : '' }}>Sent</option>
                    <option value="0" {{ request('sent') == '0' ? 'selected' : '' }}>Not sent</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                <a href="{{ route('web.bm-client.index') }}" class="btn btn-sm btn-light">Reset</a>
            </form>
        </div>

        {{-- Table --}}
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name / Company</th>
                    <th>Mobile</th>
                    <th>Website</th>
                    <th>Status</th>
                    <th>Sent</th>
                    <th>Response</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td class="text-muted">{{ $clients->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-medium">{{ $client->name }}</div>
                            <small class="text-muted">{{ $client->company_name }}</small>
                        </td>
                        <td class="text-muted">{{ $client->mobile_number ?? '—' }}</td>
                        <td>
                            @if ($client->website)
                                <a href="{{ $client->website }}" target="_blank" class="text-primary text-decoration-none"
                                    style="font-size:.78rem">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>
                                    {{ parse_url($client->website, PHP_URL_HOST) }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge rounded-pill {{ $client->status ? 'badge-enabled' : 'badge-disabled' }}">
                                {{ $client->status ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge rounded-pill {{ $client->sent ? 'badge-sent' : 'badge-unsent' }}">
                                {{ $client->sent ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            @if ($client->response)
                                <span
                                    class="{{ str_contains(strtolower($client->response), 'fail') || str_contains(strtolower($client->response), 'error') ? 'text-danger' : 'text-success' }}"
                                    style="font-size:.78rem" title="{{ $client->response }}">
                                    {{ Str::limit($client->response, 30) }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $client->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1 flex-nowrap">
                                {{-- Send mail --}}
                                <button type="button" class="btn btn-sm btn-success btn-send-mail" data-bs-toggle="modal"
                                    data-bs-target="#sendMailModal" data-client-id="{{ $client->id }}"
                                    data-client-name="{{ $client->company_name }}"
                                    data-client-email="{{ $client->email }}">
                                    <i class="bi bi-envelope-arrow-up"></i>
                                </button>
                                {{-- Edit --}}
                                <a href="{{ route('web.bm-client.edit', $client) }}" class="btn btn-sm btn-light"><i
                                        class="bi bi-pencil"></i></a>
                                {{-- Delete --}}
                                <form action="{{ route('web.bm-client.destroy', $client) }}" method="POST"
                                    onsubmit="return confirm('Delete this client?')">
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
                        <td colspan="9" class="text-center text-muted py-5">No clients found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="bm-pagination">
            <span class="page-info">Showing {{ $clients->firstItem() }}–{{ $clients->lastItem() }} of
                {{ $clients->total() }}</span>
            {{ $clients->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- ── Send Mail Modal ─────────────────────────────── --}}
    <div class="modal fade" id="sendMailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-envelope-arrow-up me-2 text-success"></i>
                        Send Mail — <span id="sm_company" class="text-primary"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div id="sm_alert"></div>
                <form id="sendMailForm">
                    @csrf
                    <input type="hidden" id="sm_client_id">
                    <div class="modal-body">
                        <div class="alert alert-light border d-flex align-items-center gap-2 py-2 mb-3">
                            <i class="bi bi-envelope text-muted"></i>
                            <span style="font-size:.82rem">
                                Recipient: <strong id="sm_email" class="text-primary"></strong>
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                Select Mail Template <span class="text-danger">*</span>
                            </label>
                            <select id="sm_template" class="form-select" required>
                                <option value="">— Choose template —</option>
                                @foreach ($enabledTemplates as $tmpl)
                                    <option value="{{ $tmpl->id }}" data-subject="{{ $tmpl->subject }}">
                                        {{ $tmpl->name }} — {{ Str::limit($tmpl->short_description, 40) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Subject preview --}}
                        <div id="sm_preview" class="alert alert-info py-2 d-none" style="font-size:.8rem">
                            <strong>Subject preview:</strong> <span id="sm_preview_text"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="sm_submit_btn" onclick="submitSendMail()">
                            <i class="bi bi-send me-1"></i> Send Mail
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Bulk Mail Modal ─────────────────────────────── --}}
    <div class="modal fade" id="bulkMailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-send-fill me-2" style="color:#7c3aed"></i>
                        Bulk Mail Campaign
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div id="bulk_alert"></div>
                <form id="bulkMailForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                Select Mail Template <span class="text-danger">*</span>
                            </label>
                            <select id="bulk_template" class="form-select" required>
                                <option value="">— Choose template —</option>
                                @foreach ($enabledTemplates as $tmpl)
                                    <option value="{{ $tmpl->id }}">
                                        {{ $tmpl->name }} — {{ $tmpl->short_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-medium mb-0">
                                    Select Companies
                                    <small class="text-muted fw-normal">(enabled clients only)</small>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                    <label class="form-check-label" for="selectAll" style="font-size:.8rem">
                                        Select all
                                    </label>
                                </div>
                            </div>
                            <div class="border rounded" style="max-height:260px;overflow-y:auto">
                                <table class="table table-sm table-hover mb-0" style="font-size:.82rem">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th style="width:36px"></th>
                                            <th>Company / Name</th>
                                            <th>Email</th>
                                            <th>Last sent</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activeClients as $client)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input bulk-client-check" type="checkbox"
                                                        value="{{ $client->id }}">
                                                </td>
                                                <td>
                                                    <div class="fw-medium">{{ $client->company_name }}</div>
                                                    <small class="text-muted">{{ $client->name }}</small>
                                                </td>
                                                <td class="text-muted">{{ $client->email }}</td>
                                                <td>
                                                    @if ($client->sent_at)
                                                        <small
                                                            class="text-muted">{{ $client->sent_at->format('d M') }}</small>
                                                    @else
                                                        <small class="text-muted">Never</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-1" style="font-size:.78rem;color:#64748b">
                                <span id="bulk_count">0</span> companies selected
                            </div>
                        </div>

                        {{-- Progress bar --}}
                        <div id="bulk_progress" class="d-none mt-3">
                            <div class="d-flex justify-content-between mb-1" style="font-size:.78rem">
                                <span id="bulk_progress_text">Sending…</span>
                                <span id="bulk_progress_pct">0%</span>
                            </div>
                            <div class="progress" style="height:6px">
                                <div class="progress-bar bg-primary" id="bulk_progress_bar" style="width:0%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn" style="background:#7c3aed;color:#fff;border:none"
                            id="bulk_submit_btn" onclick="submitBulkMail()">
                            <i class="bi bi-send-fill me-1"></i> Launch Campaign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // ── Single send modal ───────────────────────────────
        document.querySelectorAll('.btn-send-mail').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('sm_company').textContent = btn.dataset.clientName;
                document.getElementById('sm_email').textContent = btn.dataset.clientEmail;
                document.getElementById('sm_client_id').value = btn.dataset.clientId;
                document.getElementById('sm_template').value = '';
                document.getElementById('sm_alert').innerHTML = '';
                document.getElementById('sm_preview').classList.add('d-none');
            });
        });

        document.getElementById('sm_template').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            const preview = document.getElementById('sm_preview');
            if (this.value) {
                document.getElementById('sm_preview_text').textContent = opt.dataset.subject || '';
                preview.classList.remove('d-none');
            } else {
                preview.classList.add('d-none');
            }
        });

        async function submitSendMail() {
            const clientId = document.getElementById('sm_client_id').value;
            const templateId = document.getElementById('sm_template').value;
            const alertEl = document.getElementById('sm_alert');
            const btn = document.getElementById('sm_submit_btn');

            if (!templateId) {
                alertEl.innerHTML = `<div class="alert alert-warning m-3 py-2">Please select a mail template.</div>`;
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sending…';
            alertEl.innerHTML = '';

            const res = await fetch(`/admin/business-mail/clients/${clientId}/send-mail`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    template_id: templateId
                })
            });
            const data = await res.json();

            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-send me-1"></i> Send Mail';

            if (data.success) {
                alertEl.innerHTML =
                    `<div class="alert alert-success m-3 py-2"><i class="bi bi-check-circle-fill me-1"></i> ${data.message}</div>`;
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('sendMailModal')).hide();
                    location.reload();
                }, 1800);
            } else {
                alertEl.innerHTML =
                    `<div class="alert alert-danger m-3 py-2"><i class="bi bi-exclamation-triangle-fill me-1"></i> ${data.message}</div>`;
            }
        }

        // ── Bulk send ───────────────────────────────────────
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.bulk-client-check').forEach(c => c.checked = this.checked);
            updateBulkCount();
        });
        document.querySelectorAll('.bulk-client-check').forEach(c => c.addEventListener('change', updateBulkCount));

        function updateBulkCount() {
            document.getElementById('bulk_count').textContent =
                document.querySelectorAll('.bulk-client-check:checked').length;
        }

        async function submitBulkMail() {
            const templateId = document.getElementById('bulk_template').value;
            const checked = [...document.querySelectorAll('.bulk-client-check:checked')].map(c => c.value);
            const alertEl = document.getElementById('bulk_alert');
            const btn = document.getElementById('bulk_submit_btn');

            if (!templateId) {
                alertEl.innerHTML = `<div class="alert alert-warning m-3 py-2">Please select a template.</div>`;
                return;
            }
            if (!checked.length) {
                alertEl.innerHTML = `<div class="alert alert-warning m-3 py-2">Select at least one company.</div>`;
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sending…';
            alertEl.innerHTML = '';

            document.getElementById('bulk_progress').classList.remove('d-none');
            document.getElementById('bulk_progress_text').textContent = `Sending to ${checked.length} companies…`;

            const res = await fetch(`/admin/business-mail/clients/bulk-send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    client_ids: checked,
                    template_id: templateId
                })
            });
            const data = await res.json();

            document.getElementById('bulk_progress_bar').style.width = '100%';
            document.getElementById('bulk_progress_pct').textContent = '100%';
            document.getElementById('bulk_progress_text').textContent =
                `${data.data?.sent ?? 0} sent, ${data.data?.failed ?? 0} failed`;

            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-send-fill me-1"></i> Launch Campaign';

            alertEl.innerHTML = data.success ?
                `<div class="alert alert-success m-3 py-2"><i class="bi bi-check-circle-fill me-1"></i> ${data.message}</div>` :
                `<div class="alert alert-warning m-3 py-2"><i class="bi bi-exclamation-triangle-fill me-1"></i> ${data.message}</div>`;

            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('bulkMailModal')).hide();
                location.reload();
            }, 2500);
        }

        // Auto-open bulk modal if ?bulk=1
        if (new URLSearchParams(location.search).get('bulk') === '1') {
            new bootstrap.Modal(document.getElementById('bulkMailModal')).show();
        }
    </script>
@endpush
