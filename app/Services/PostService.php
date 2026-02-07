<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class PostService
{
    /**
     * Получить ленту всех постов с пагинацией.
     */
    public function getFeed(int $perPage = 10): LengthAwarePaginator
    {
        return Post::with(['user', 'likes'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Получить посты конкретного пользователя.
     */
    public function getUserPosts(User $user): Collection
    {
        return $user->posts()
            ->with(['likes'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get();
    }

    /**
     * Создать новый пост.
     */
    public function store(array $data, ?UploadedFile $image = null): Post
    {
        if ($image) {
            $data['image'] = $image->store('posts', 'public');
        }

        return Post::create($data);
    }

    /**
     * Обновить существующий пост.
     */
    public function update(Post $post, array $data, ?UploadedFile $image = null, bool $removeImage = false): Post
    {
        if ($image) {
            $this->deleteImage($post);
            $data['image'] = $image->store('posts', 'public');
        }

        if ($removeImage) {
            $this->deleteImage($post);
            $data['image'] = null;
        }

        $post->update($data);

        return $post;
    }

    /**
     * Удалить пост и его изображение.
     */
    public function delete(Post $post): void
    {
        $this->deleteImage($post);
        $post->delete();
    }

    /**
     * Удалить изображение поста с диска.
     */
    private function deleteImage(Post $post): void
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
    }
}
