@extends('layouts.app')

@section('title', 'Лента')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            {{-- Заголовок --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0"><i class="bi bi-fire text-warning"></i> Лента постов</h4>
                </div>
                @auth
                    <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-plus-lg"></i> Создать пост
                    </a>
                @endauth
            </div>

            {{-- Пустое состояние --}}
            @if($posts->isEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-body empty-state text-center">
                        <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                        <h5 class="fw-bold mt-3">Пока нет ни одного поста</h5>
                        <p class="text-muted">Станьте первым, кто напишет что-то интересное</p>
                        @auth
                            <a href="{{ route('posts.create') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-pencil-square"></i> Создать пост
                            </a>
                        @endauth
                    </div>
                </div>
            @else
                @foreach($posts as $post)
                    <div class="card card-hover border-0 shadow-sm mb-4">
                        {{-- Изображение --}}
                        @if($post->getImageUrl())
                            <a href="{{ route('posts.show', $post) }}">
                                <img src="{{ $post->getImageUrl() }}" class="card-img-top" alt="{{ $post->title }}"
                                     style="max-height: 400px; object-fit: cover;">
                            </a>
                        @endif

                        <div class="card-body p-4">
                            {{-- Автор --}}
                            <div class="d-flex align-items-center mb-3">
                                <x-avatar :user="$post->user" :size="42" />
                                <div class="ms-3">
                                    <span class="fw-semibold">{{ $post->user->name }}</span>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>

                            {{-- Контент --}}
                            <a href="{{ route('posts.show', $post) }}" class="post-title-link">
                                <h5 class="fw-bold mb-2">{{ $post->title }}</h5>
                            </a>
                            <p class="text-muted mb-0">{{ Str::limit($post->body, 200) }}</p>

                            {{-- Действия --}}
                            <div class="d-flex align-items-center gap-2 mt-3 pt-3 border-top">
                                @auth
                                    <form action="{{ route('posts.like', $post) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-like {{ $post->isLikedBy(Auth::user()) ? 'liked' : '' }}">
                                            <i class="bi {{ $post->isLikedBy(Auth::user()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                            {{ $post->likes->count() }}
                                        </button>
                                    </form>
                                @else
                                    <span class="btn-like" style="cursor: default;">
                                        <i class="bi bi-heart"></i>
                                        {{ $post->likes->count() }}
                                    </span>
                                @endauth

                                <a href="{{ route('posts.show', $post) }}" class="btn-comment">
                                    <i class="bi bi-chat"></i>
                                    {{ $post->comments->count() }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Пагинация --}}
                <div class="d-flex justify-content-center mt-2">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
