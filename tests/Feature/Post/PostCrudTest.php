<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_feed_is_accessible_to_everyone(): void
    {
        $response = $this->get(route('feed'));

        $response->assertStatus(200);
    }

    public function test_guest_is_redirected_to_login_when_creating_post(): void
    {
        $response = $this->get(route('posts.create'));

        $response->assertRedirect(route('view.login'));
    }

    public function test_authenticated_user_can_see_create_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.create'));

        $response->assertStatus(200);
        $response->assertViewIs('Posts.create');
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => 'Test Post Title',
            'body' => 'Test post body content.',
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'body' => 'Test post body content.',
            'user_id' => $user->id,
        ]);
    }

    public function test_post_creation_fails_with_invalid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => '',
            'body' => '',
        ]);

        $response->assertSessionHasErrors(['title', 'body']);
    }

    public function test_author_can_edit_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('posts.update', $post), [
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_author_can_delete_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('posts.index'));
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_other_user_cannot_update_post(): void
    {
        $author = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);

        $response = $this->actingAs($other)->put(route('posts.update', $post), [
            'title' => 'Hacked',
            'body' => 'Hacked body.',
        ]);

        $response->assertForbidden();
    }

    public function test_other_user_cannot_delete_post(): void
    {
        $author = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);

        $response = $this->actingAs($other)->delete(route('posts.destroy', $post));

        $response->assertForbidden();
    }

    public function test_feed_shows_posts(): void
    {
        $post = Post::factory()->create(['title' => 'Feed Post']);

        $response = $this->get(route('feed'));

        $response->assertStatus(200);
        $response->assertSee('Feed Post');
    }

    public function test_user_can_see_own_posts_list(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'title' => 'My Post']);

        $response = $this->actingAs($user)->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee('My Post');
    }
}
