<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Лента всех постов на главной
    public function feed()
    {
        $posts = Post::with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(10);

        return view('welcome', compact('posts'));
    }

    //Вывод всех постов текущего пользователя
    public function index()
    {
        $posts = Auth::user()
            ->posts()
            ->with(['likes', 'comments'])
            ->latest()
            ->get();

        return view('Posts.index', compact('posts'));
    }

    public function create()
    {
        return view('Posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ];

        // Загрузка изображения если есть
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'likes', 'comments.user']);
        return view('Posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('Posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = [
            'title' => $request->title,
            'body' => $request->body,
        ];

        // Загрузка нового изображения если есть
        if ($request->hasFile('image')) {
            // Удалить старое изображение
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        // Удаление изображения по запросу
        if ($request->has('remove_image') && $request->remove_image) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = null;
        }

        $post->update($data);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        if(Auth::id() === $post->user_id)
        {
            // Удалить изображение при удалении поста
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->delete();
            return redirect()->route('posts.index');
        }

        return response(null, 403);
    }
}
