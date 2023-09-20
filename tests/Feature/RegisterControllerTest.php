<?php

namespace Tests\Feature;

use App\Http\Controllers\RegisterController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_returns_register_view()
    {
        // Visit the registration page
        $response = $this->get('/register');

        // Assert that the response has a successful status code (e.g., 200)
        $response->assertStatus(200);

        // Assert that the registration view is returned
        $response->assertViewIs('register');

        // Optionally, you can assert the presence of specific elements in the view
        $response->assertSee('Register');
        $response->assertSee('Name');
        $response->assertSee('Email');
        $response->assertSee('Password');
    }
}
