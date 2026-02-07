# Blog Platform

Полнофункциональное веб-приложение блог-платформы, построенное на Laravel 12. Реализована авторизация, CRUD постов и комментариев, система лайков, загрузка изображений и аватаров.

## Стек технологий

| Технология | Версия | Назначение |
|---|---|---|
| **PHP** | 8.2+ | Серверный язык |
| **Laravel** | 12 | PHP-фреймворк |
| **MySQL** | 8.0+ | База данных |
| **Bootstrap** | 5.3 | UI-фреймворк |
| **Vite** | 6 | Сборка фронтенда |
| **SASS/SCSS** | — | CSS-препроцессор |
| **PHPUnit** | 11 | Тестирование |

## Функционал

- **Авторизация** — регистрация, вход, выход, смена пароля
- **Посты** — создание, редактирование, удаление, лента с пагинацией
- **Комментарии** — добавление, редактирование, удаление
- **Лайки** — toggle-лайк на постах (один лайк от пользователя)
- **Загрузка изображений** — аватары пользователей и изображения к постам
- **Профиль** — статистика (посты, лайки, дней на сайте), последние записи
- **Настройки** — изменение имени, email, пароля, аватара

## Архитектура

### Service Layer

Бизнес-логика вынесена из контроллеров в сервисный слой:

```
app/Services/
├── PostService.php       # CRUD постов, работа с изображениями
├── CommentService.php    # CRUD комментариев
└── LikeService.php       # Toggle лайков
```

Контроллеры отвечают только за обработку HTTP-запросов и делегируют логику сервисам.

### Policies (авторизация)

Права доступа реализованы через Laravel Policies:

```
app/Policies/
├── PostPolicy.php        # update, delete — только автор
└── CommentPolicy.php     # update, delete — только автор
```

Используются через `$this->authorize()` в контроллерах вместо ручных проверок.

### Form Requests

Валидация вынесена в отдельные Request-классы:

```
app/Http/Requests/
├── Auth/
│   ├── UserLoginRequest.php
│   └── UserRegisterRequest.php
├── Comment/
│   ├── StoreCommentRequest.php
│   └── UpdateCommentRequest.php
├── Post/
│   ├── StorePostRequest.php
│   └── UpdatePostRequest.php
└── Settings/
    ├── UserUpdatePasswordRequest.php
    └── UserUpdateRequest.php
```

### API Resources

Подготовлены Resource-классы для единообразной трансформации данных:

```
app/Http/Resources/
├── PostResource.php      # Трансформация поста
├── PostCollection.php    # Коллекция с мета-данными пагинации
└── CommentResource.php   # Трансформация комментария
```

### Service Container & Providers

В `AppServiceProvider` зарегистрированы:

- **Singleton-биндинги** сервисов (`PostService`, `CommentService`, `LikeService`)
- **`Model::preventLazyLoading()`** — защита от N+1 проблем в dev/testing
- **`Model::preventSilentlyDiscardingAttributes()`** — защита от ошибок fillable

### Решение N+1 проблемы

- Все запросы используют `with()` для eager loading связей
- Подсчёты реализованы через `withCount()` вместо загрузки всех записей
- `preventLazyLoading()` в non-production окружении выбрасывает исключение при ленивой загрузке

### Маршрутизация

Маршруты разделены по файлам:

```
routes/
├── web.php           # Главная (лента)
└── web/
    ├── auth.php      # Авторизация, профиль, настройки
    └── post.php      # Посты, комментарии, лайки
```

## Установка и запуск

```bash
# Клонировать репозиторий
git clone https://github.com/your-username/pet-project.git
cd pet-project

# Установить зависимости
composer install
npm install

# Настроить окружение
cp .env.example .env
php artisan key:generate

# Настроить базу данных в .env
# DB_DATABASE=pet_project
# DB_USERNAME=your_user
# DB_PASSWORD=your_password

# Выполнить миграции
php artisan migrate

# Создать символическую ссылку для хранилища
php artisan storage:link

# Собрать фронтенд
npm run build

# Запустить сервер
php artisan serve
```

## Запуск тестов

```bash
# Создать тестовую базу данных
mysql -u your_user -p -e "CREATE DATABASE IF NOT EXISTS pet_project_testing;"

# Запустить все тесты
php artisan test

# Запустить конкретный набор
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

### Покрытие тестами

| Набор | Тестов | Описание |
|---|---|---|
| **Feature/Auth** | 12 | Регистрация, вход, валидация |
| **Feature/Post** | 11 | CRUD постов, авторизация, лента |
| **Feature/Comment** | 5 | Комментарии, права доступа |
| **Feature/Like** | 3 | Toggle лайков |
| **Unit/Models** | 8 | Связи моделей, методы |
| **Unit/Services** | 5 | Сервисный слой |
| **Итого** | **44** | |

## Структура проекта

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   └── UserController.php
│   │   ├── CommentController.php
│   │   ├── LikeController.php
│   │   └── PostController.php
│   ├── Requests/         # Form Request валидация
│   └── Resources/        # API Resources
├── Models/
│   ├── User.php
│   ├── Post.php
│   ├── Comment.php
│   └── Like.php
├── Policies/             # Авторизация действий
├── Providers/
│   └── AppServiceProvider.php
└── Services/             # Бизнес-логика
tests/
├── Feature/
│   ├── Auth/
│   ├── Comment/
│   ├── Like/
│   └── Post/
└── Unit/
    ├── Models/
    └── Services/
```

## Лицензия

MIT
