<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post)
    {
        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->route('posts.show', ['post' => $post]);
    }

    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        $comment->update([
            'comment' => $request->comment,
        ]);

        return redirect()->route('posts.show', ['post' => $post]);
    }

    public function destroy(Post $post, Comment $comment)
    {
        if(Auth::id() === $comment->user_id)
        {
            $comment->delete();
            return redirect()->route('posts.show', ['post' => $post]);
        }

        return response(null, 403);
    }
}
