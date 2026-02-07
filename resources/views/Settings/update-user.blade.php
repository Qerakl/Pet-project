@extends('layouts.app')

@section('title', 'Настройки')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Заголовок --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('view.profile') }}" class="text-decoration-none text-muted me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h4 class="fw-bold mb-0"><i class="bi bi-gear text-primary me-2"></i> Настройки профиля</h4>
            </div>

            {{-- Алерты --}}
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 d-flex align-items-center alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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

            {{-- Аватар --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-person-circle me-2 text-primary"></i> Аватар</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-4 flex-shrink-0">
                            @if($user->getAvatarUrl())
                                <img src="{{ $user->getAvatarUrl() }}" alt="Аватар"
                                     class="rounded-circle avatar-ring"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 100px; height: 100px;">
                                    <span class="fs-1 fw-bold">{{ $user->getInitial() }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <form action="{{ route('update.avatar') }}" method="POST" enctype="multipart/form-data" class="mb-2">
                                @csrf
                                <div class="input-group mb-2">
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                           name="avatar" accept="image/*">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-upload me-1"></i> Загрузить
                                    </button>
                                </div>
                                @error('avatar')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i> JPEG, PNG, GIF, WebP. Макс. 2MB
                                </small>
                            </form>

                            @if($user->avatar)
                                <form action="{{ route('delete.avatar') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                            onclick="return confirm('Удалить аватар?')">
                                        <i class="bi bi-trash me-1"></i> Удалить аватар
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Основная информация --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-person me-2 text-primary"></i> Основная информация</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('update.user', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">
                                <i class="bi bi-person me-1 text-muted"></i> Имя
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">
                                <i class="bi bi-envelope me-1 text-muted"></i> Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i> Сохранить изменения
                        </button>
                    </form>
                </div>
            </div>

            {{-- Смена пароля --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-shield-lock me-2 text-warning"></i> Смена пароля</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('update.user.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-medium">
                                <i class="bi bi-lock me-1 text-muted"></i> Текущий пароль
                            </label>
                            <input type="password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-medium">
                                <i class="bi bi-lock-fill me-1 text-muted"></i> Новый пароль
                            </label>
                            <input type="password"
                                   class="form-control @error('new_password') is-invalid @enderror"
                                   id="new_password" name="new_password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-medium">
                                <i class="bi bi-lock-fill me-1 text-muted"></i> Подтвердите новый пароль
                            </label>
                            <input type="password" class="form-control"
                                   id="new_password_confirmation" name="new_password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-warning rounded-pill px-4">
                            <i class="bi bi-key me-1"></i> Сменить пароль
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
