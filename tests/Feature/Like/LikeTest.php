<?php

namespace Tests\Feature\Like;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_like_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.like', $post));

        $response->assertRedirect();
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_authenticated_user_can_unlike_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        // Сначала лайкаем
        $this->actingAs($user)->post(route('posts.like', $post));
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Потом снимаем лайк
        $response = $this->actingAs($user)->post(route('posts.like', $post));

        $response->assertRedirect();
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_guest_cannot_like_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->post(route('posts.like', $post));

        $response->assertRedirect(route('view.login'));
    }
}
