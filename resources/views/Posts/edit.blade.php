@extends('layouts.app')

@section('title', 'Редактирование поста')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            {{-- Навигация --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('posts.index') }}" class="text-decoration-none text-muted me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h4 class="fw-bold mb-0"><i class="bi bi-pencil text-primary me-2"></i> Редактирование поста</h4>
            </div>

            {{-- Ошибки --}}
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label fw-medium">
                                <i class="bi bi-type-h1 me-1 text-muted"></i> Заголовок
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title', $post->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label fw-medium">
                                <i class="bi bi-text-paragraph me-1 text-muted"></i> Текст поста
                            </label>
                            <textarea class="form-control @error('body') is-invalid @enderror"
                                      id="body"
                                      name="body"
                                      rows="10">{{ old('body', $post->body) }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label fw-medium">
                                <i class="bi bi-image me-1 text-muted"></i> Изображение
                            </label>

                            {{-- Текущее изображение --}}
                            @if($post->getImageUrl())
                                <div class="mb-3 p-3 bg-light rounded-3" id="current-image">
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ $post->getImageUrl() }}" alt="{{ $post->title }}"
                                             class="img-fluid rounded-3" style="max-height: 250px;" id="current-img">
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-check d-inline-flex align-items-center">
                                            <input type="checkbox" name="remove_image" value="1" class="form-check-input me-2"
                                                   onchange="toggleRemoveImage(this)">
                                            <span class="form-check-label text-danger small">
                                                <i class="bi bi-trash me-1"></i> Удалить текущее изображение
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <input type="file"
                                   class="form-control @error('image') is-invalid @enderror"
                                   id="image"
                                   name="image"
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i> Загрузите новое, чтобы заменить текущее. JPEG, PNG, GIF, WebP. Макс. 5MB
                            </small>

                            {{-- Превью нового --}}
                            <div id="image-preview" class="mt-3 d-none">
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-arrow-right me-1"></i> Новое изображение:
                                </p>
                                <div class="position-relative d-inline-block">
                                    <img src="" alt="Превью" class="img-fluid rounded-3" style="max-height: 250px;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle"
                                            onclick="clearImage()" style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-check-lg me-1"></i> Сохранить
                            </button>
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function clearImage() {
            const input = document.getElementById('image');
            const preview = document.getElementById('image-preview');
            input.value = '';
            preview.classList.add('d-none');
        }

        function toggleRemoveImage(checkbox) {
            const img = document.getElementById('current-img');
            if (img) {
                img.style.opacity = checkbox.checked ? '0.3' : '1';
                img.style.transition = 'opacity 0.3s ease';
            }
        }
    </script>
@endsection
