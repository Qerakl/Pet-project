@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="col-12 auth-card">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    {{-- Иконка и заголовок --}}
                    <div class="text-center mb-4">
                        <div class="auth-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </div>
                        <h3 class="fw-bold">Вход в аккаунт</h3>
                        <p class="text-muted">Рады видеть вас снова!</p>
                    </div>

                    {{-- Ошибки --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="login-email" class="form-label fw-medium">
                                <i class="bi bi-envelope me-1 text-muted"></i> Почта
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="login-email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="example@mail.com"
                                       autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="login-password" class="form-label fw-medium">
                                <i class="bi bi-lock me-1 text-muted"></i> Пароль
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="login-password"
                                       name="password"
                                       placeholder="Введите пароль">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Войти
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <span class="text-muted">Нет аккаунта?</span>
                        <a href="{{ route('view.register') }}" class="fw-semibold text-decoration-none">Зарегистрируйтесь</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
