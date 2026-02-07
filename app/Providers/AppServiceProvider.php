<?php

namespace App\Providers;

use App\Services\CommentService;
use App\Services\LikeService;
use App\Services\PostService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Явная регистрация сервисов в контейнере (singleton для переиспользования)
        $this->app->singleton(PostService::class);
        $this->app->singleton(CommentService::class);
        $this->app->singleton(LikeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Запретить ленивую загрузку в dev — ловим N+1 проблемы
        Model::preventLazyLoading(! app()->isProduction());

        // Запретить тихое отбрасывание атрибутов не в fillable
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());
    }
}
