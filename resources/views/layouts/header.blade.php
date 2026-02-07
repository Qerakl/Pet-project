<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('feed') }}">
            <i class="bi bi-newspaper text-primary me-2 fs-4"></i>
            <span>MyBlog</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto ms-3">
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('feed') ? 'active fw-semibold' : '' }}" href="{{ route('feed') }}">
                        <i class="bi bi-house-door"></i> Главная
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('posts.*') ? 'active fw-semibold' : '' }}" href="{{ route('posts.index') }}">
                            <i class="bi bi-journal-text"></i> Мои посты
                        </a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav align-items-center">
                @auth
                    {{-- Быстрая кнопка создания поста --}}
                    <li class="nav-item me-2">
                        <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="bi bi-plus-lg"></i> Написать
                        </a>
                    </li>

                    {{-- Dropdown пользователя --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center py-1 px-2 rounded-pill" href="#"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false"
                           style="background: rgba(0,0,0,0.04);">
                            <x-avatar :user="Auth::user()" :size="30" />
                            <span class="ms-2 me-1 fw-medium">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <x-avatar :user="Auth::user()" :size="40" />
                                    <div class="ms-2">
                                        <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('view.profile') }}">
                                    <i class="bi bi-person me-2 text-muted"></i> Профиль
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('posts.index') }}">
                                    <i class="bi bi-journal-text me-2 text-muted"></i> Мои посты
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('view.settings') }}">
                                    <i class="bi bi-gear me-2 text-muted"></i> Настройки
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Выйти
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('view.login') ? 'active' : '' }}" href="{{ route('view.login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Вход
                        </a>
                    </li>
                    <li class="nav-item ms-1">
                        <a class="btn btn-primary btn-sm rounded-pill px-3" href="{{ route('view.register') }}">
                            <i class="bi bi-person-plus"></i> Регистрация
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
