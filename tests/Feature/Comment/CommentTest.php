<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_add_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.store', $post), [
            'comment' => 'Great post!',
        ]);

        $response->assertRedirect(route('posts.show', $post));
        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'Great post!',
        ]);
    }

    public function test_guest_cannot_add_comment(): void
    {
        $post = Post::factory()->create();

        $response = $this->post(route('comments.store', $post), [
            'comment' => 'Should fail',
        ]);

        $response->assertRedirect(route('view.login'));
    }

    public function test_author_can_delete_own_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(
            route('comments.destroy', [$post, $comment])
        );

        $response->assertRedirect(route('posts.show', $post));
        $this->assertSoftDeleted('comments', ['id' => $comment->id]);
    }

    public function test_other_user_cannot_delete_comment(): void
    {
        $author = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $author->id,
        ]);

        $response = $this->actingAs($other)->delete(
            route('comments.destroy', [$post, $comment])
        );

        $response->assertForbidden();
    }

    public function test_comment_validation_fails_with_empty_body(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.store', $post), [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors('comment');
    }
}
