<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_belongs_to_user(): void
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->user);
    }

    public function test_post_has_many_comments(): void
    {
        $post = Post::factory()->create();
        Comment::factory()->count(3)->create(['post_id' => $post->id]);

        $this->assertCount(3, $post->comments);
    }

    public function test_post_has_many_likes(): void
    {
        $post = Post::factory()->create();
        $users = User::factory()->count(2)->create();

        foreach ($users as $user) {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        }

        $this->assertCount(2, $post->fresh()->likes);
    }

    public function test_is_liked_by_returns_true_when_liked(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->assertTrue($post->isLikedBy($user));
    }

    public function test_is_liked_by_returns_false_when_not_liked(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->assertFalse($post->isLikedBy($user));
    }

    public function test_is_liked_by_returns_false_for_null_user(): void
    {
        $post = Post::factory()->create();

        $this->assertFalse($post->isLikedBy(null));
    }

    public function test_get_image_url_returns_url_when_image_exists(): void
    {
        $post = Post::factory()->create(['image' => 'posts/test.jpg']);

        $this->assertStringContainsString('storage/posts/test.jpg', $post->getImageUrl());
    }

    public function test_get_image_url_returns_null_when_no_image(): void
    {
        $post = Post::factory()->create(['image' => null]);

        $this->assertNull($post->getImageUrl());
    }
}
