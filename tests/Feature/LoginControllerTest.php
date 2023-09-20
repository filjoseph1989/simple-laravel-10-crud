<?php

namespace Tests\Feature;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_with_valid_credentials()
    {
        // Create a user.
        $user = User::factory()->create();

        // Submit the login form with valid credentials.
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Assert that the user is redirected to the dashboard page.
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function login_with_invalid_credentials()
    {
        // Submit the login form with invalid credentials.
        $response = $this->post('/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalid',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);

        // Assert that the user is not authenticated
        $this->assertFalse(Auth::check());
    }
}