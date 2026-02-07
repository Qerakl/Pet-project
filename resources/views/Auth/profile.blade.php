@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Карточка профиля --}}
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                {{-- Баннер --}}
                <div class="profile-banner"></div>

                <div class="card-body text-center" style="margin-top: -75px;">
                    {{-- Аватар --}}
                    <div class="mb-3">
                        @if($user->getAvatarUrl())
                            <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}"
                                 class="rounded-circle avatar-ring"
                                 style="width: 130px; height: 130px; object-fit: cover;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto avatar-ring"
                                 style="width: 130px; height: 130px;">
                                <span class="display-4 fw-bold">{{ $user->getInitial() }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Имя --}}
                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-4">
                        <i class="bi bi-envelope me-1"></i> {{ $user->email }}
                    </p>

                    {{-- Статистика --}}
                    <div class="d-flex justify-content-center mb-4">
                        <div class="stat-item">
                            <h4 class="fw-bold mb-0">{{ $user->posts->count() }}</h4>
                            <small class="text-muted">{{ trans_choice('пост|поста|постов', $user->posts->count()) }}</small>
                        </div>
                        <div class="stat-item">
                            <h4 class="fw-bold mb-0">{{ $user->likes->count() }}</h4>
                            <small class="text-muted">{{ trans_choice('лайк|лайка|лайков', $user->likes->count()) }}</small>
                        </div>
                        <div class="stat-item">
                            <h4 class="fw-bold mb-0">{{ (int) $user->created_at->diffInDays(now()) }}</h4>
                            <small class="text-muted">{{ trans_choice('день|дня|дней', (int) $user->created_at->diffInDays(now())) }} на сайте</small>
                        </div>
                    </div>

                    {{-- Кнопки --}}
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('posts.index') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-journal-text me-1"></i> Мои посты
                        </a>
                        <a href="{{ route('view.settings') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-gear me-1"></i> Настройки
                        </a>
                    </div>
                </div>
            </div>

            {{-- Последние посты --}}
            @if($user->posts->count() > 0)
                <div class="d-flex align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history text-primary me-2"></i> Последние посты
                    </h5>
                </div>

                @foreach($user->posts()->latest()->take(3)->get() as $post)
                    <div class="card card-hover border-0 shadow-sm mb-3">
                        <div class="row g-0">
                            @if($post->getImageUrl())
                                <div class="col-md-3 d-flex">
                                    <a href="{{ route('posts.show', $post) }}" class="d-block w-100">
                                        <img src="{{ $post->getImageUrl() }}" alt="{{ $post->title }}"
                                             class="img-fluid rounded-start h-100 w-100"
                                             style="object-fit: cover; min-height: 120px;">
                                    </a>
                                </div>
                            @endif
                            <div class="{{ $post->getImageUrl() ? 'col-md-9' : 'col-12' }}">
                                <div class="card-body p-3">
                                    <a href="{{ route('posts.show', $post) }}" class="post-title-link">
                                        <h6 class="fw-bold mb-2">{{ $post->title }}</h6>
                                    </a>
                                    <p class="text-muted small mb-2">{{ Str::limit($post->body, 100) }}</p>
                                    <div class="d-flex align-items-center gap-3 text-muted small">
                                        <span><i class="bi bi-heart me-1"></i>{{ $post->likes()->count() }}</span>
                                        <span><i class="bi bi-chat me-1"></i>{{ $post->comments()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($user->posts->count() > 3)
                    <div class="text-center mt-3">
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                            Все посты <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
