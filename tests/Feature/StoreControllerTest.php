<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function index_displays_stores_for_authenticated_user()
    {
        // Create a user and stores associated with that user
        $user = User::factory()->create();
        $stores = Store::factory()->count(12)->create(['user_id' => $user->id]);

        // Act.
        $response = $this->actingAs($user)->get('/store');

        // Assert.
        $response->assertStatus(200);
        $response->assertViewIs('stores.index');
        $response->assertSee('Stores');

        $stores = $response->viewData('stores');
        $this->assertEquals(9, $stores->count());

        $storeChunks = $response->viewData('storeChunks');
        $this->assertEquals(3, count($storeChunks));
    }

    /** @test */
    public function index_redirects_guest_users_to_login()
    {
        // Visit the index page as a guest user
        $response = $this->get(route('store.index'));

        // Assert that guest users are redirected to the login page
        $response->assertRedirect(route('login'));
    }
}
