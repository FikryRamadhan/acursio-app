<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_login_requires_email_and_password()
    {
        $response = $this->postJson('/authLogin', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password123'),
        ]);

        $response = $this->postJson('/authLogin', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Login successful',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/authLogin', [
            'email' => 'hudson.bertrand@example.org',
            'password' => 'passworda',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Invalid credentials',
        ]);

        $this->assertGuest();
    }
}
