@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="col-12 auth-card">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    {{-- Иконка и заголовок --}}
                    <div class="text-center mb-4">
                        <div class="auth-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h3 class="fw-bold">Создать аккаунт</h3>
                        <p class="text-muted">Присоединяйтесь к сообществу!</p>
                    </div>

                    {{-- Ошибки --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                <ul class="mb-0 ps-0" style="list-style: none;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="reg-name" class="form-label fw-medium">
                                <i class="bi bi-person me-1 text-muted"></i> Имя
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person text-muted"></i></span>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="reg-name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Ваше имя"
                                       autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reg-email" class="form-label fw-medium">
                                <i class="bi bi-envelope me-1 text-muted"></i> Почта
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="reg-email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="example@mail.com">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reg-password" class="form-label fw-medium">
                                <i class="bi bi-lock me-1 text-muted"></i> Пароль
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="reg-password"
                                       name="password"
                                       placeholder="Минимум 8 символов">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="reg-password-confirm" class="form-label fw-medium">
                                <i class="bi bi-lock-fill me-1 text-muted"></i> Подтвердите пароль
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password"
                                       class="form-control"
                                       id="reg-password-confirm"
                                       name="password_confirmation"
                                       placeholder="Повторите пароль">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                            <i class="bi bi-person-plus me-1"></i> Зарегистрироваться
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <span class="text-muted">Уже есть аккаунт?</span>
                        <a href="{{ route('view.login') }}" class="fw-semibold text-decoration-none">Войдите</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
