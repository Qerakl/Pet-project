<footer class="site-footer py-4 mt-auto">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                <a href="{{ route('feed') }}" class="text-decoration-none text-dark fw-bold">
                    <i class="bi bi-newspaper text-primary"></i> MyBlog
                </a>
            </div>
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <small class="text-muted">&copy; {{ date('Y') }} MyBlog. Все права защищены.</small>
            </div>
            <div class="col-md-4 text-center text-md-end">
                <a href="{{ route('feed') }}" class="text-muted text-decoration-none me-3">
                    <i class="bi bi-house"></i> Главная
                </a>
                @auth
                    <a href="{{ route('posts.index') }}" class="text-muted text-decoration-none">
                        <i class="bi bi-journal-text"></i> Посты
                    </a>
                @endauth
            </div>
        </div>
    </div>
</footer>
