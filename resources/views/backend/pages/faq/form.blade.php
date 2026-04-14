@extends('layouts.app')
@section('title', isset($faq) ? 'Edit FAQ' : 'New FAQ')
@section('page-title', isset($faq) ? 'Edit FAQ' : 'New FAQ')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
<style>
    
    /* ── Page wrapper ─────────────────────────────── */
    .faq-page-wrapper { max-width: 780px; margin: 2.5rem auto; padding: 0 1rem 4rem; }

    /* ── Breadcrumb / back link ───────────────────── */
    .faq-back {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .85rem; color: #6b7280; text-decoration: none;
        margin-bottom: 1.5rem; transition: all .2s cubic-bezier(.4,0,.2,1);
    }
    .faq-back:hover { color: #4f46e5; }
    .faq-back svg { width: 16px; height: 16px; }

    /* ── Main card ────────────────────────────────── */
    .faq-card {
        background: #ffffff; border-radius: 14px;
        box-shadow: 0 4px 24px rgba(79,70,229,.07), 0 1px 4px rgba(0,0,0,.05); border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .faq-card-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: space-between;
        background: linear-gradient(135deg, #fafbff 0%, #f0f0ff 100%);
    }

    .faq-card-title {
        font-family: 'Sora', sans-serif;
        font-size: 1.15rem; font-weight: 700;
        color: #111827; margin: 0;
        display: flex; align-items: center; gap: .6rem;
    }
    .faq-card-title .title-icon {
        width: 36px; height: 36px; border-radius:  10px;
        background: #ede9fe;
        display: flex; align-items: center; justify-content: center;
    }
    .faq-card-title .title-icon svg { width: 18px; height: 18px; color: #ede9fe; }

    .faq-card-body { padding: 2rem; }

    /* ── Section label ────────────────────────────── */
    .section-label {
        font-family: 'Sora', sans-serif;
        font-size: .7rem; font-weight: 700; letter-spacing: .12em;
        text-transform: uppercase; color: #6b7280;
        margin-bottom: 1rem;
    }

    /* ── FAQ item card ────────────────────────────── */
    .faq-item {
        background: #fafbff; border: 1.5px solid #e5e7eb;
        border-radius: 10px; padding: 1.25rem 1.25rem 1rem;
        margin-bottom: 1rem; position: relative;
        transition: all .2s cubic-bezier(.4,0,.2,1); animation: slideIn .25s ease;
    }
    .faq-item:hover { border-color: #a5b4fc; box-shadow:  0 2px 10px rgba(0,0,0,.06); }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* item header with number badge + remove */
    .faq-item-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1rem;
    }
    .faq-num {
        font-family: 'Sora', sans-serif; font-size: .78rem; font-weight: 700;
        color: #4f46e5; background: #ede9fe;
        border-radius: 20px; padding: .2rem .7rem;
    }

    /* ── Form controls ────────────────────────────── */
    .faq-label {
        display: block; font-size: .82rem; font-weight: 600;
        color: #111827; margin-bottom: .35rem;
    }
    .faq-label span { color: #ef4444; margin-left: 2px; }

    .faq-input, .faq-textarea {
        width: 100%; padding: .6rem .85rem;
        background: #fff; border: 1.5px solid #e5e7eb;
        border-radius: 7px; font-family: 'DM Sans', sans-serif;
        font-size: .9rem; color: #111827;
        transition: all .2s cubic-bezier(.4,0,.2,1); outline: none; resize: vertical;
    }
    .faq-input::placeholder, .faq-textarea::placeholder { color: #c4c9d6; }
    .faq-input:focus, .faq-textarea:focus {
        border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,.12);
    }
    .faq-textarea { min-height: 90px; }

    /* validation error */
    .faq-input.is-invalid, .faq-textarea.is-invalid { border-color: #ef4444; }
    .faq-error { font-size: .78rem; color: #ef4444; margin-top: .3rem; }

    /* ── Buttons ──────────────────────────────────── */
    .btn-add {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .5rem 1.1rem; background: #4f46e5;
        color: #fff; border: none; border-radius: 7px;
        font-family: 'DM Sans', sans-serif; font-size: .85rem; font-weight: 600;
        cursor: pointer; transition: all .2s cubic-bezier(.4,0,.2,1);
    }
    .btn-add:hover { background: #4338ca; transform: translateY(-1px); }
    .btn-add svg { width: 15px; height: 15px; }

    .btn-remove {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .3rem .75rem; background: #fef2f2;
        color: #ef4444; border: 1.5px solid #fecaca;
        border-radius: 7px; font-size: .8rem; font-weight: 600;
        cursor: pointer; transition: all .2s cubic-bezier(.4,0,.2,1); white-space: nowrap;
    }
    .btn-remove:hover { background: #ef4444; color: #fff; border-color: #ef4444; }
    .btn-remove svg { width: 13px; height: 13px; }

    /* ── Divider ──────────────────────────────────── */
    .faq-divider { border: none; border-top: 1px dashed #e5e7eb; margin: 1.5rem 0; }

    /* ── Status toggle ────────────────────────────── */
    .status-row {
        display: flex; align-items: center; justify-content: space-between;
        background: #f9fafb; border: 1.5px solid #e5e7eb;
        border-radius: 10px; padding: .85rem 1.1rem;
        margin-bottom: 1.5rem;
    }
    .status-info .status-title {
        font-weight: 600; font-size: .9rem; color: #111827;
    }
    .status-info .status-desc { font-size: .78rem; color: #6b7280; margin-top: 2px; }

    /* Custom toggle switch */
    .toggle-wrap { display: flex; align-items: center; gap: .5rem; }
    .toggle-switch {
        position: relative; display: inline-block; width: 46px; height: 26px;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0; background: #d1d5db;
        border-radius: 99px; cursor: pointer; transition: .3s;
    }
    .toggle-slider::before {
        content: ''; position: absolute; width: 20px; height: 20px;
        left: 3px; top: 3px; background: #fff;
        border-radius: 50%; transition: .3s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    .toggle-switch input:checked + .toggle-slider { background: #10b981; }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }
    .toggle-label { font-size: .85rem; font-weight: 600; color: #111827; }

    /* ── Footer actions ───────────────────────────── */
    .faq-footer {
        display: flex; align-items: center; gap: .75rem;
        padding-top: 1.25rem; border-top: 1px solid #e5e7eb;
        flex-wrap: wrap;
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .65rem 1.4rem; background: #4f46e5;
        color: #fff; border: none; border-radius: 7px;
        font-family: 'DM Sans', sans-serif; font-size: .9rem; font-weight: 600;
        cursor: pointer; transition: all .2s cubic-bezier(.4,0,.2,1);
    }
    .btn-submit:hover { background: #4338ca; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(79,70,229,.3); }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .65rem 1.2rem; background: #fff;
        color: #6b7280; border: 1.5px solid #e5e7eb;
        border-radius: 7px; text-decoration: none;
        font-family: 'DM Sans', sans-serif; font-size: .9rem; font-weight: 500;
        transition: all .2s cubic-bezier(.4,0,.2,1);
    }
    .btn-cancel:hover { border-color: #9ca3af; color: #111827; }

    /* ── Empty state (no items) ───────────────────── */
    .faq-empty {
        text-align: center; padding: 2.5rem 1rem;
        color: #6b7280; font-size: .9rem; display: none;
    }
    .faq-empty svg { width: 42px; height: 42px; margin-bottom: .75rem; color: #d1d5db; }

    /* ── Alert / errors ───────────────────────────── */
    .faq-alert {
        background: #fef2f2; border: 1px solid #fecaca;
        border-radius: 10px; padding: .85rem 1.1rem;
        margin-bottom: 1.25rem; font-size: .85rem; color: #ef4444;
    }
    .faq-alert ul { margin: .4rem 0 0 1rem; }
</style>
@endpush

@section('content')
<div class="faq-page-wrapper">

    {{-- Back link --}}
    <a href="{{ route('web.faq.index') }}" class="faq-back">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to FAQ list
    </a>

    <div class="faq-card">

        {{-- Header --}}
        <div class="faq-card-header">
            <h1 class="faq-card-title">
                <span class="title-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                {{ isset($faq) ? 'Edit FAQ' : 'Create FAQ' }}
            </h1>
            <button type="button" class="btn-add" id="addFaq">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Question
            </button>
        </div>

        {{-- Body --}}
        <div class="faq-card-body">

            {{-- Laravel validation errors --}}
            @if($errors->any())
            <div class="faq-alert">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" enctype="multipart/form-data"
                action="{{ isset($faq) ? route('web.faq.update', $faq->id) : route('web.faq.store') }}">

                @csrf
                @if(isset($faq))
                    @method('PUT')
                @endif

                {{-- FAQ Items wrapper --}}
                <p class="section-label">Questions &amp; Answers</p>

                <div id="faqWrapper">

                    {{-- Empty state --}}
                    <div class="faq-empty" id="faqEmpty">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>
                        <p>No questions yet. Click <strong>Add Question</strong> to get started.</p>
                    </div>

                    {{-- ── EDIT MODE: render existing FAQ rows ── --}}
                    @if(isset($faq) && is_array($faq->faqs ?? null))
                        @foreach($faq->faqs as $i => $item)
                        <div class="faq-item" data-index="{{ $i }}">
                            <div class="faq-item-header">
                                <span class="faq-num">Q{{ $i + 1 }}</span>
                                <button type="button" class="btn-remove removeFaq">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Remove
                                </button>
                            </div>
                            <div class="mb-2">
                                <label class="faq-label">Question <span>*</span></label>
                                <input type="text" name="faq[{{ $i }}][question]"
                                    class="faq-input @error('faq.'.$i.'.question') is-invalid @enderror"
                                    placeholder="e.g. How do I reset my password?"
                                    value="{{ old('faq.'.$i.'.question', $item['question'] ?? '') }}">
                                @error('faq.'.$i.'.question')
                                    <div class="faq-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="faq-label">Answer <span>*</span></label>
                                <textarea name="faq[{{ $i }}][answer]"
                                    class="faq-textarea @error('faq.'.$i.'.answer') is-invalid @enderror"
                                    placeholder="Write a clear, helpful answer…">{{ old('faq.'.$i.'.answer', $item['answer'] ?? '') }}</textarea>
                                @error('faq.'.$i.'.answer')
                                    <div class="faq-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endforeach

                    @else
                        {{-- ── CREATE MODE: one blank default row ── --}}
                        <div class="faq-item" data-index="0">
                            <div class="faq-item-header">
                                <span class="faq-num">Q1</span>
                                <button type="button" class="btn-remove removeFaq">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Remove
                                </button>
                            </div>
                            <div class="mb-2">
                                <label class="faq-label">Question <span>*</span></label>
                                <input type="text" name="faq[0][question]"
                                    class="faq-input @error('faq.0.question') is-invalid @enderror"
                                    placeholder="e.g. How do I reset my password?"
                                    value="{{ old('faq.0.question', '') }}">
                                @error('faq.0.question')
                                    <div class="faq-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="faq-label">Answer <span>*</span></label>
                                <textarea name="faq[0][answer]"
                                    class="faq-textarea @error('faq.0.answer') is-invalid @enderror"
                                    placeholder="Write a clear, helpful answer…">{{ old('faq.0.answer', '') }}</textarea>
                                @error('faq.0.answer')
                                    <div class="faq-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endif

                </div>{{-- /#faqWrapper --}}

                <hr class="faq-divider">

                {{-- Status toggle --}}
                <div class="status-row">
                    <div class="status-info">
                        <div class="status-title">Status</div>
                        <div class="status-desc">Toggle to activate or deactivate this FAQ group.</div>
                    </div>
                    <div class="toggle-wrap">
                        <label class="toggle-switch">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" value="1"
                                {{ old('status', $faq->status ?? 1) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label" id="toggleLabel">
                            {{ old('status', $faq->status ?? 1) ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                {{-- Footer actions --}}
                <div class="faq-footer">
                    <button type="submit" class="btn-submit">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}
                    </button>
                    <a href="{{ route('web.faq.index') }}" class="btn-cancel">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const wrapper  = document.getElementById('faqWrapper');
    const emptyMsg = document.getElementById('faqEmpty');
    const addBtn   = document.getElementById('addFaq');

    /* ── Utils ───────────────────── */

    const getItems = () => wrapper.querySelectorAll('.faq-item');

    const updateUI = () => {
        getItems().forEach((item, i) => {
            item.dataset.index = i;

            item.querySelector('.faq-num').textContent = `Q${i + 1}`;

            item.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace(/faq\[\d+\]/, `faq[${i}]`);
            });
        });

        emptyMsg.style.display = getItems().length ? 'none' : 'block';
    };

    /* ── Add Item ───────────────── */

    addBtn.addEventListener('click', () => {
        const index = getItems().length;

        const template = `
        <div class="faq-item" data-index="${index}">
            <div class="faq-item-header">
                <span class="faq-num">Q${index + 1}</span>
                <button type="button" class="btn-remove removeFaq">Remove</button>
            </div>

            <div class="mb-2">
                <label class="faq-label">Question *</label>
                <input type="text" name="faq[${index}][question]" class="faq-input">
            </div>

            <div>
                <label class="faq-label">Answer *</label>
                <textarea name="faq[${index}][answer]" class="faq-textarea"></textarea>
            </div>
        </div>`;

        wrapper.insertAdjacentHTML('beforeend', template);
        updateUI();
    });

    /* ── Remove Item ────────────── */

    wrapper.addEventListener('click', e => {
        const btn = e.target.closest('.removeFaq');
        if (!btn) return;

        btn.closest('.faq-item').remove();
        updateUI();
    });

    updateUI();
});
</script>
@endpush