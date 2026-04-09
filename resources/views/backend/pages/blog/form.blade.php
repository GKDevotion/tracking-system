@extends('layouts.app')
@section('title', isset($blog) ? 'Edit Blog' : 'New Blog')
@section('page-title', isset($blog) ? 'Edit Blog' : 'New Blog')

@section('content')
    <div class="row g-4">
        {{-- Form --}}
        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-file-text text-primary"></i>
                    <strong>{{ isset($blog) ? 'Edit Blog' : 'New Blog' }}</strong>
                </div>
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ isset($blog) ? route('web.blogs.update', $blog) : route('web.blogs.store') }}">
                        @csrf
                        @if (isset($blog))
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            {{-- Title --}}
                            <div class="col-12">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="titleInput"
                                    value="{{ old('title', $blog->title ?? '') }}"
                                    class="form-control @error('title') is-invalid @enderror" placeholder="Enter blog title"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Category --}}

                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control category_id" id="category_id" name="category_id">
                                        <option value="0">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $blog->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <div class="error">{{ $errors->first('category_id') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="sub_category_id">Sub Category</label>
                                    <select class="form-control sub_category_id" id="sub_category_id"
                                        name="sub_category_id">
                                        <option value="0">Select Sub Category</option>
                                        @foreach ($categories as $category)
                                            @if ($category->childrenRecursive->isNotEmpty())
                                                @foreach ($category->childrenRecursive as $subCategory)
                                                    <option value="{{ $subCategory->id }}"
                                                        class="d-none sub-category parent-category-{{ $category->id }}"
                                                        {{ old('sub_category_id', $blog->sub_category_id ?? '') == $subCategory->id ? 'selected' : '' }}>
                                                        {{ $subCategory->title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('sub_category_id'))
                                        <div class="error">{{ $errors->first('sub_category_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Short Description --}}
                            <div class="col-12">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror"
                                    placeholder="Enter short description">{{ old('short_description', $blog->short_description ?? '') }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea id="description" name="description" rows="5"
                                    class="form-control @error('description') is-invalid @enderror" placeholder="Enter full description">{{ old('description', $blog->description ?? '') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Keywords --}}
                            <div class="col-12">
                                <label class="form-label">Keywords (SEO)</label>
                                <input type="text" name="keyword" value="{{ old('keyword', $blog->keyword ?? '') }}"
                                    class="form-control @error('keyword') is-invalid @enderror"
                                    placeholder="Enter keywords separated by commas">
                                @error('keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Podcast URL --}}
                            <div class="col-md-6">
                                <label class="form-label">Podcast URL</label>
                                <input type="url" name="podcast_url"
                                    value="{{ old('podcast_url', $blog->podcast_url ?? '') }}"
                                    class="form-control @error('podcast_url') is-invalid @enderror"
                                    placeholder="https://example.com/podcast">
                                @error('podcast_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sort URL --}}
                            <div class="col-md-6">
                                <label class="form-label">Sort URL</label>
                                <input type="url" name="sort_url" value="{{ old('sort_url', $blog->sort_url ?? '') }}"
                                    class="form-control @error('sort_url') is-invalid @enderror"
                                    placeholder="https://example.com">
                                @error('sort_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Image Upload --}}
                            <div class="col-12">
                                <label class="form-label">Featured Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror">

                                @if (isset($blog) && $blog->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/app/public/' . $blog->image) }}" width="100"
                                            class="rounded">
                                    </div>
                                @endif

                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tags --}}
                            <div class="col-12">
                                <label class="form-label">Tags</label>
                                <select name="tags[]" class="form-select" multiple style="height: 150px;">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            {{ isset($blog) && $blog->tags->pluck('id')->contains($tag->id) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple tags</small>
                            </div>

                            {{-- Status --}}
                            <div class="col-12">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" value="1"
                                        id="statusSwitch" {{ old('status', $blog->status ?? 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusSwitch">
                                        Active
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>{{ isset($blog) ? 'Update' : 'Create' }} Blog
                                </button>
                                <a href="{{ route('web.blogs.index') }}" class="btn btn-secondary ms-2">
                                    <i class="bi bi-arrow-left me-1"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ]
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        function updateSubCategories(selectedCategoryId) {
            const subCategoryOptions = document.querySelectorAll('.sub-category');

            // Hide all sub-category options
            subCategoryOptions.forEach(option => {
                option.classList.add('d-none');
            });

            // Show sub-categories for the selected parent category
            if (selectedCategoryId && selectedCategoryId != '0') {
                const relevantSubCategories = document.querySelectorAll('.parent-category-' + selectedCategoryId);
                relevantSubCategories.forEach(option => {
                    option.classList.remove('d-none');
                });
            }
        }

        // Update sub-categories based on selected category
        document.getElementById('category_id').addEventListener('change', function() {
            const selectedCategoryId = this.value;
            updateSubCategories(selectedCategoryId);

            // Reset sub-category selection when category changes
            document.getElementById('sub_category_id').value = '0';
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const selectedCategoryId = categorySelect.value;

            if (selectedCategoryId && selectedCategoryId != '0') {
                updateSubCategories(selectedCategoryId);
            }
        });
    </script>
@endpush
