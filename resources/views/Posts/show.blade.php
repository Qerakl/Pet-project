@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            {{-- Навигация --}}
            <nav class="mb-4">
                <a href="{{ route('feed') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left me-1"></i> Назад к ленте
                </a>
            </nav>

            {{-- Карточка поста --}}
            <article class="card border-0 shadow-sm mb-4">
                {{-- Изображение --}}
                @if($post->getImageUrl())
                    <img src="{{ $post->getImageUrl() }}" class="card-img-top" alt="{{ $post->title }}"
                         style="max-height: 500px; object-fit: cover;">
                @endif

                <div class="card-body p-4">
                    {{-- Автор --}}
                    <div class="d-flex align-items-center mb-4">
                        <x-avatar :user="$post->user" :size="48" />
                        <div class="ms-3">
                            <span class="fw-semibold">{{ $post->user->name }}</span>
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>{{ $post->created_at->format('d.m.Y') }}
                                <span class="mx-1">&middot;</span>
                                <i class="bi bi-clock me-1"></i>{{ $post->created_at->format('H:i') }}
                            </small>
                        </div>

                        {{-- Управление --}}
                        @auth
                            @if(Auth::id() === $post->user_id)
                                <div class="ms-auto d-flex gap-2">
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-pencil"></i> Редактировать
                                    </a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                onclick="return confirm('Удалить пост?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>

                    {{-- Контент --}}
                    <h2 class="fw-bold mb-3">{{ $post->title }}</h2>
                    <div class="text-body mb-4" style="white-space: pre-line; line-height: 1.8;">{{ $post->body }}</div>

                    {{-- Лайки и коммент-счётчик --}}
                    <div class="d-flex align-items-center gap-3 pt-3 border-top">
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

                        <span class="btn-comment" style="cursor: default;">
                            <i class="bi bi-chat"></i>
                            {{ $post->comments->count() }}
                        </span>
                    </div>
                </div>
            </article>

            {{-- Комментарии --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-chat-dots me-2 text-primary"></i>
                        Комментарии
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill ms-1">{{ $post->comments->count() }}</span>
                    </h6>
                </div>
                <div class="card-body p-4">
                    {{-- Форма --}}
                    @auth
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="d-flex">
                                <div class="me-3 flex-shrink-0">
                                    <x-avatar :user="Auth::user()" :size="38" />
                                </div>
                                <div class="flex-grow-1">
                                    <textarea
                                        name="comment"
                                        class="form-control border @error('comment') is-invalid @enderror"
                                        rows="3"
                                        placeholder="Напишите комментарий..."
                                        required
                                    >{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="text-end mt-2">
                                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">
                                            <i class="bi bi-send me-1"></i> Отправить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-light border rounded-3 d-flex align-items-center mb-4">
                            <i class="bi bi-info-circle text-primary me-2"></i>
                            <a href="{{ route('view.login') }}" class="fw-semibold text-decoration-none">Войдите</a>
                            <span class="ms-1">, чтобы оставить комментарий</span>
                        </div>
                    @endauth

                    {{-- Список --}}
                    @if($post->comments->isEmpty())
                        <div class="empty-state text-center">
                            <div class="empty-icon"><i class="bi bi-chat-square"></i></div>
                            <h6 class="fw-bold mt-3">Пока нет комментариев</h6>
                            <p class="text-muted small">Будьте первым, кто поделится мнением!</p>
                        </div>
                    @else
                        @foreach($post->comments()->with('user')->latest()->get() as $comment)
                            <div class="d-flex mb-3" id="comment-{{ $comment->id }}">
                                <div class="me-3 flex-shrink-0">
                                    <x-avatar :user="$comment->user" :size="36" />
                                </div>
                                <div class="flex-grow-1">
                                    <div class="bg-light rounded-3 p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <div>
                                                <span class="fw-semibold">{{ $comment->user->name }}</span>
                                                <small class="text-muted ms-2">
                                                    <i class="bi bi-clock"></i> {{ $comment->created_at->diffForHumans() }}
                                                </small>
                                            </div>

                                            @auth
                                                @if(Auth::id() === $comment->user_id)
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                            <li>
                                                                <button class="dropdown-item py-2" type="button" onclick="editComment({{ $comment->id }})">
                                                                    <i class="bi bi-pencil me-2 text-muted"></i> Редактировать
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('comments.destroy', [$post, $comment]) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item py-2 text-danger"
                                                                            onclick="return confirm('Удалить комментарий?')">
                                                                        <i class="bi bi-trash me-2"></i> Удалить
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>

                                        {{-- Текст --}}
                                        <p class="mb-0 comment-text" id="comment-text-{{ $comment->id }}">{{ $comment->comment }}</p>

                                        {{-- Форма редактирования --}}
                                        <form action="{{ route('comments.update', [$post, $comment]) }}" method="POST"
                                              class="d-none mt-2" id="edit-form-{{ $comment->id }}">
                                            @csrf
                                            @method('PUT')
                                            <textarea name="comment" class="form-control form-control-sm mb-2" rows="2">{{ $comment->comment }}</textarea>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Сохранить</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                                        onclick="cancelEdit({{ $comment->id }})">Отмена</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function editComment(id) {
            document.getElementById('comment-text-' + id).classList.add('d-none');
            document.getElementById('edit-form-' + id).classList.remove('d-none');
        }

        function cancelEdit(id) {
            document.getElementById('comment-text-' + id).classList.remove('d-none');
            document.getElementById('edit-form-' + id).classList.add('d-none');
        }
    </script>
@endsection
