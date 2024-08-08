@extends('layouts.app')

@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    <i class="fas fa-edit me-2"></i> Bloq Redaktə Et
                </h1>
            </div>
            <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="editForm" novalidate>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="card">
                            <div class="card-body">
                                @if($errors->any())
                                    <div class="mb-3">
                                        @foreach($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                - {{ $error }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Tabs Navigation -->
                                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                                    @foreach(['az' => 'Azərbaycanca', 'en' => 'İngilizcə', 'ru' => 'Rusca'] as $lang => $label)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{ request()->query('lang', 'az') === $lang ? 'active' : '' }}" id="{{ $lang }}-tab" data-bs-toggle="tab" href="#{{ $lang }}" role="tab" aria-controls="{{ $lang }}" aria-selected="{{ request()->query('lang', 'az') === $lang ? 'true' : 'false' }}">{{ $label }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Tabs Content -->
                                <div class="tab-content mt-3" id="languageTabsContent">
                                    @foreach(['az' => 'Azərbaycanca', 'en' => 'İngilizcə', 'ru' => 'Rusca'] as $lang => $label)
                                        <div class="tab-pane fade {{ request()->query('lang', 'az') === $lang ? 'show active' : '' }}" id="{{ $lang }}" role="tabpanel" aria-labelledby="{{ $lang }}-tab">
                                            <div class="mb-3">
                                                <label for="name_{{ $lang }}" class="form-label">Bloq adı {{ $label }} *</label>
                                                <input type="text" value="{{ old('name_'.$lang, $blog->{"contents".strtoupper($lang)}->name ?? '') }}" placeholder="Bloq adını daxil edin" class="form-control @error('name_'.$lang) is-invalid @enderror" id="name_{{ $lang }}" name="name_{{ $lang }}">
                                                @error('name_'.$lang)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="content_{{ $lang }}" class="form-label">Məzmun {{ $label }} *</label>
                                                <textarea name="content_{{ $lang }}" id="content_{{ $lang }}" class="form-control @error('content_'.$lang) is-invalid @enderror">{{ old('content_'.$lang, $blog->{"contents".strtoupper($lang)}->content ?? '') }}</textarea>
                                                @error('content_'.$lang)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <hr>
                                            <div class="mb-3">
                                                <label for="title_{{ $lang }}" class="form-label">Title {{ $label }} *</label>
                                                <input type="text" name="title_{{ $lang }}" id="title_{{ $lang }}" class="form-control @error('title_'.$lang) is-invalid @enderror" value="{{ old('title_'.$lang, $blog->{"contents".strtoupper($lang)}->title ?? '') }}" />
                                                @error('title_'.$lang)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="description_{{ $lang }}" class="form-label">Description {{ $label }} *</label>
                                                <input type="text" name="description_{{ $lang }}" id="description_{{ $lang }}" class="form-control @error('description_'.$lang) is-invalid @enderror" value="{{ old('description_'.$lang, $blog->{"contents".strtoupper($lang)}->description ?? '') }}" />
                                                @error('description_'.$lang)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="folder" value="blog">

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="published" {{ $blog->status === 'published' ? 'selected' : '' }}>Paylaş</option>
                                        <option value="draft" {{ $blog->status === 'draft' ? 'selected' : '' }}>Qaralama</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="published_at_wrapper">
                                    <label for="published_at" class="form-label">Paylaşılma vaxtı *</label>
                                    <input type="date" class="form-control" name="published_at" id="published_at" value="{{ old('published_at', $blog->published_at) }}" />
                                    @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="author_id" class="form-label">Müəllif *</label>
                                    <select disabled class="form-control @error('author_id') is-invalid @enderror" id="author_id" name="author_id">
                                        @foreach($authors as $author)
                                            <option value="{{ $author->id }}" @selected($author->id === $blog->author_id)>{{ $author->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('author_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Kateqoriya *</label>
                                    <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                                        @foreach($blogCategories as $category)
                                            <option value="{{ $category->id }}" @selected($category->id === $blog->category_id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Əsas şəkil *</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($blog->featured_image)
                                        <div id="single_image_preview" class="mt-2">
                                            <img src="{{ asset('storage/'.$blog->featured_image) }}" alt="Current Image" class="img-fluid"/>
                                        </div>
                                    @else
                                        <div id="single_image_preview" class="mt-2"></div>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-success">Yenilə</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 250px;
        }
        .ck-content .image img {
            width: 400px!important;
        }
    </style>
@endpush
@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize CKEditor for each language
            ['az', 'en', 'ru'].forEach(lang => {
                ClassicEditor
                    .create(document.querySelector(`#content_${lang}`), {
                        ckfinder: {
                            uploadUrl: `{{ route('image.upload') }}?_token={{ csrf_token() }}&folder=blog&lang=${lang}`
                        },
                        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', '|', 'imageUpload', 'imageResize', '|', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', 'undo', 'redo' ]
                    })
                    .then(editor => {
                        // Add a reference to the editor instance
                        document.querySelector(`#content_${lang}`).editor = editor;
                    })
                    .catch(error => {
                        console.error(`Error initializing #content_${lang} editor:`, error);
                    });
            });

            // Image preview functionality
            document.getElementById('image').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('single_image_preview');
                        preview.innerHTML = `<img src="${e.target.result}" alt="Selected Image" class="img-fluid"/>`;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Validate CKEditor content before form submission
            function validateCKEditors() {
                let isValid = true;
                ['az', 'en', 'ru'].forEach(lang => {
                    const editorData = document.querySelector(`#content_${lang}`).editor.getData();
                    if (editorData.trim() === '') {
                        isValid = false;
                        document.querySelector(`#content_${lang}`).classList.add('is-invalid');
                    } else {
                        document.querySelector(`#content_${lang}`).classList.remove('is-invalid');
                    }
                });
                return isValid;
            }

            document.getElementById('editForm').addEventListener('submit', function(event) {
                if (!validateCKEditors()) {
                    event.preventDefault();
                    // Display a generic error message if needed
                    alert('Please fill in all required fields.');
                }
            });

            // Update required attributes based on active tab
            function updateRequiredFields() {
                const activeLang = document.querySelector('.nav-link.active').getAttribute('id').split('-')[0];

                // Update required attributes for visible tab
                ['az', 'en', 'ru'].forEach(lang => {
                    const isActive = lang === activeLang;
                    document.querySelectorAll(`#${lang} input, #${lang} textarea`).forEach(element => {
                        if (isActive) {
                            element.setAttribute('required', 'required');
                        } else {
                            element.removeAttribute('required');
                        }
                    });
                });
            }

            // Show or hide published_at field based on status
            function togglePublishedAt() {
                const status = document.getElementById('status').value;
                const publishedAtField = document.querySelector('input[name="published_at"]').parentElement;
                const publishedAtInput = document.querySelector('input[name="published_at"]');
                if (status === 'published') {
                    publishedAtField.style.display = 'block';
                    publishedAtInput.setAttribute('required', 'required');
                } else {
                    publishedAtField.style.display = 'none';
                    publishedAtInput.removeAttribute('required');
                }
            }

            // Call the functions initially and on status change
            updateRequiredFields();
            togglePublishedAt();

            document.querySelectorAll('#languageTabs .nav-link').forEach(tab => {
                tab.addEventListener('shown.bs.tab', updateRequiredFields);
            });

            document.getElementById('status').addEventListener('change', togglePublishedAt);
        });
    </script>
@endpush
