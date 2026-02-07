<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService
    ) {}

    /**
     * Добавить комментарий к посту.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $this->commentService->store($post, Auth::id(), $request->comment);

        return redirect()->route('posts.show', $post);
    }

    /**
     * Обновить комментарий.
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        $this->authorize('update', $comment);

        $this->commentService->update($comment, $request->comment);

        return redirect()->route('posts.show', $post);
    }

    /**
     * Удалить комментарий.
     */
    public function destroy(Post $post, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $this->commentService->delete($comment);

        return redirect()->route('posts.show', $post);
    }
}
