<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_see_registration_form(): void
    {
        $response = $this->get(route('view.register'));

        $response->assertStatus(200);
        $response->assertViewIs('Auth.register');
    }

    public function test_guest_can_register(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);
    }

    public function test_authenticated_user_cannot_see_registration_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('view.register'));

        $response->assertRedirect('/');
    }

    public function test_registration_fails_with_empty_fields(): void
    {
        $response = $this->post(route('register'), []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_registration_fails_with_short_password(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_fails_when_passwords_do_not_match(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $response = $this->post(route('register'), [
            'name' => 'Test',
            'email' => 'taken@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
