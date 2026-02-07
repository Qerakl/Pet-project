@extends('layouts.app')

@section('title', 'Мои посты')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Заголовок --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <h4 class="fw-bold mb-0"><i class="bi bi-journal-text text-primary"></i> Мои посты</h4>
                    <span class="badge bg-primary rounded-pill">{{ $posts->count() }}</span>
                </div>
                <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-plus-lg"></i> Создать пост
                </a>
            </div>

            {{-- Алерты --}}
            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Пустое состояние --}}
            @if($posts->isEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-body empty-state text-center">
                        <div class="empty-icon"><i class="bi bi-journal-x"></i></div>
                        <h5 class="fw-bold mt-3">У вас пока нет постов</h5>
                        <p class="text-muted">Создайте свой первый пост и поделитесь мыслями</p>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-pencil-square"></i> Создать первый пост
                        </a>
                    </div>
                </div>
            @else
                @foreach($posts as $post)
                    <div class="card card-hover border-0 shadow-sm mb-3">
                        <div class="row g-0">
                            {{-- Миниатюра --}}
                            @if($post->getImageUrl())
                                <div class="col-md-3 d-flex">
                                    <a href="{{ route('posts.show', $post) }}" class="d-block w-100">
                                        <img src="{{ $post->getImageUrl() }}" alt="{{ $post->title }}"
                                             class="img-fluid rounded-start h-100 w-100"
                                             style="object-fit: cover; min-height: 140px;">
                                    </a>
                                </div>
                            @endif

                            <div class="{{ $post->getImageUrl() ? 'col-md-9' : 'col-12' }}">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1 me-3">
                                            <a href="{{ route('posts.show', $post) }}" class="post-title-link">
                                                <h6 class="fw-bold mb-2">{{ $post->title }}</h6>
                                            </a>
                                            <p class="text-muted small mb-3">{{ Str::limit($post->body, 120) }}</p>

                                            <div class="d-flex align-items-center gap-3 text-muted small">
                                                <span>
                                                    <i class="bi bi-calendar3 me-1"></i>{{ $post->created_at->format('d.m.Y') }}
                                                </span>
                                                <span class="{{ $post->likes->count() > 0 ? 'text-danger' : '' }}">
                                                    <i class="bi bi-heart{{ $post->likes->count() > 0 ? '-fill' : '' }} me-1"></i>{{ $post->likes->count() }}
                                                </span>
                                                <span>
                                                    <i class="bi bi-chat me-1"></i>{{ $post->comments->count() }}
                                                </span>
                                                @if($post->image)
                                                    <span class="text-success">
                                                        <i class="bi bi-image"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="d-flex gap-1">
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-primary rounded-circle"
                                               title="Редактировать" style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"
                                                        onclick="return confirm('Удалить пост?')" title="Удалить"
                                                        style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
