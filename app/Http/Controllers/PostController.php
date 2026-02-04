<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //Вывод всех постов текущего пользователя
    public function index()
    {
        $posts = Auth::user()
            ->posts()
            ->latest()->
            orderBy('created_at', 'desc')
            ->get();

        return view('Posts.index', compact('posts'));
    }

    public function create()
    {
        return view('Posts.create');
    }

    public function store(StorePostRequest $request)
    {
        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        return view('Posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('Posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        if(Auth::id() === $post->user_id)
        {
            $post->delete();
            return redirect()->route('posts.index');
        }

        return response(null, 403);
    }
}
