<?php

namespace Tests\Unit\Services;

use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    private PostService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(PostService::class);
    }

    public function test_store_creates_post_in_database(): void
    {
        $user = User::factory()->create();

        $post = $this->service->store([
            'title' => 'Service Test',
            'body' => 'Created via service.',
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Service Test',
        ]);
    }

    public function test_update_changes_post_data(): void
    {
        $post = Post::factory()->create(['title' => 'Old']);

        $this->service->update($post, ['title' => 'New', 'body' => $post->body]);

        $this->assertEquals('New', $post->fresh()->title);
    }

    public function test_delete_soft_deletes_post(): void
    {
        $post = Post::factory()->create();

        $this->service->delete($post);

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_get_feed_returns_paginated_posts(): void
    {
        Post::factory()->count(15)->create();

        $result = $this->service->getFeed(10);

        $this->assertCount(10, $result->items());
        $this->assertEquals(15, $result->total());
    }

    public function test_get_user_posts_returns_only_user_posts(): void
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create(['user_id' => $user->id]);
        Post::factory()->count(5)->create(); // другие пользователи

        $posts = $this->service->getUserPosts($user);

        $this->assertCount(3, $posts);
    }
}
