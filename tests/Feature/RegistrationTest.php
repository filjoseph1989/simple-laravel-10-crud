<?php

namespace Tests\Feature;

use Hash;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_register()
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function a_user_cannot_register_with_an_existing_email_address()
    {
        User::create([
            'name' => 'Existing User',
            'first_name' => 'Existing',
            'last_name' => 'User',
            'email' => 'existing@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'existing@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function a_user_cannot_register_with_a_short_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function a_user_cannot_register_if_the_user_creation_fails()
    {
        $userControllerMock = $this->createMock(UserController::class);
        $userControllerMock->method('register')->willReturn(false);

        $this->app->instance(UserController::class, $userControllerMock);

        $userData = [
            'name' => null,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $this->post('/register', $userData);

        // Assert that the user was not created (invalid input)
        $this->assertDatabaseMissing('users', ['email' => $userData['email']]);;
    }
}
