<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\LikeService;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct(
        private readonly LikeService $likeService
    ) {}

    /**
     * Переключить лайк на посте.
     */
    public function toggle(Post $post)
    {
        $this->likeService->toggle($post, Auth::user());

        return back();
    }
}
