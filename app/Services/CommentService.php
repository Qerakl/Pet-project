<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;

class CommentService
{
    /**
     * Создать комментарий к посту.
     */
    public function store(Post $post, int $userId, string $text): Comment
    {
        return Comment::create([
            'post_id' => $post->id,
            'user_id' => $userId,
            'comment' => $text,
        ]);
    }

    /**
     * Обновить текст комментария.
     */
    public function update(Comment $comment, string $text): Comment
    {
        $comment->update(['comment' => $text]);

        return $comment;
    }

    /**
     * Удалить комментарий.
     */
    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
