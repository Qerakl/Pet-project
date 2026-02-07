<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;

class LikeService
{
    /**
     * Переключить лайк: поставить если нет, убрать если есть.
     *
     * @return bool true если лайк поставлен, false если снят
     */
    public function toggle(Post $post, User $user): bool
    {
        $existingLike = Like::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return false;
        }

        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        return true;
    }
}
