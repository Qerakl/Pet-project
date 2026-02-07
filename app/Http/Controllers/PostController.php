<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * Лента всех постов на главной.
     */
    public function feed()
    {
        $posts = $this->postService->getFeed();

        return view('welcome', compact('posts'));
    }

    /**
     * Список постов текущего пользователя.
     */
    public function index()
    {
        $posts = $this->postService->getUserPosts(Auth::user());

        return view('Posts.index', compact('posts'));
    }

    /**
     * Форма создания поста.
     */
    public function create()
    {
        return view('Posts.create');
    }

    /**
     * Сохранение нового поста.
     */
    public function store(StorePostRequest $request)
    {
        $this->postService->store(
            [
                'title' => $request->title,
                'body' => $request->body,
                'user_id' => Auth::id(),
            ],
            $request->file('image')
        );

        return redirect()->route('posts.index');
    }

    /**
     * Просмотр поста.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'likes', 'comments.user'])
            ->loadCount(['likes', 'comments']);

        return view('Posts.show', compact('post'));
    }

    /**
     * Форма редактирования поста.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('Posts.edit', compact('post'));
    }

    /**
     * Обновление поста.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $this->postService->update(
            $post,
            [
                'title' => $request->title,
                'body' => $request->body,
            ],
            $request->file('image'),
            (bool) $request->input('remove_image', false)
        );

        return redirect()->route('posts.index');
    }

    /**
     * Удаление поста.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $this->postService->delete($post);

        return redirect()->route('posts.index');
    }
}
