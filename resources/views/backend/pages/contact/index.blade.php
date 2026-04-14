@extends('layouts.app')
@section('title','Contact List')
@section('page-title','Contact Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-text text-primary"></i>
            <strong>Contact</strong>
            <span class="badge bg-primary rounded-pill">{{ $dataArr->total() }}</span>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search contacts..." style="width:160px">

                <input type="date" name="created_at" value="{{ request('created_at') }}"
                       class="form-control form-control-sm" style="width:145px">

                <input type="date" name="updated_at" value="{{ request('updated_at') }}"
                       class="form-control form-control-sm" style="width:145px">

                <button class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>

                @if(request()->hasAny(['search','created_at','updated_at']))
                    <a href="{{ route('web.contact-us.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x"></i>
                    </a>
                @endif
            </form>

        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($dataArr as $i => $contact)
                        <tr>
                            <td>{{ $dataArr->firstItem() + $i }}</td>

                            {{-- Email --}}
                            <td>{{ $contact->email }}</td>

                            <td>{{ $contact->mobile_number }}</td>

                            <td>{{ $contact->message }}</td>

                            {{-- Status --}}
                            <td>
                                <span class="badge {{ $contact->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $contact->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- Created --}}
                            <td>{{ $contact->created_at->format('d M Y') }}</td>

                            <td>
                               

                                <form action="{{ route('web.contact-us.destroy', $contact->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Delete this contact?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                No contact found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($dataArr->hasPages())
        <div class="card-footer">
            {{ $dataArr->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush