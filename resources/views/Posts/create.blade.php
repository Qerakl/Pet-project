@extends('layouts.app')

@section('title', 'Создание поста')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            {{-- Навигация --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('posts.index') }}" class="text-decoration-none text-muted me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i> Создание поста</h4>
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
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label fw-medium">
                                <i class="bi bi-type-h1 me-1 text-muted"></i> Заголовок
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   placeholder="О чём ваш пост?">
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
                                      rows="10"
                                      placeholder="Напишите что-нибудь интересное...">{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label fw-medium">
                                <i class="bi bi-image me-1 text-muted"></i> Изображение
                                <span class="text-muted fw-normal">(необязательно)</span>
                            </label>
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
                                <i class="bi bi-info-circle me-1"></i> JPEG, PNG, GIF, WebP. Макс. 5MB
                            </small>

                            {{-- Превью --}}
                            <div id="image-preview" class="mt-3 d-none">
                                <div class="position-relative d-inline-block">
                                    <img src="" alt="Превью" class="img-fluid rounded-3" style="max-height: 300px;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle"
                                            onclick="clearImage()" style="width: 32px; height: 32px; padding: 0;">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-send me-1"></i> Опубликовать
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
    </script>
@endsection
