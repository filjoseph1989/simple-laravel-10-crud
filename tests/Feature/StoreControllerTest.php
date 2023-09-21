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

    private object $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function index_displays_stores_for_authenticated_user()
    {
        $stores = Store::factory()->count(12)->create(['user_id' => $this->user->id]);

        // Act.
        $response = $this->actingAs($this->user)->get(route('store.index'));

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
        $response = $this->actingAs($this->user)->get(route('store.index'));

        // Assert that guest users are redirected to the login page
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function create_displays_create_store_form()
    {
        // Visit the create store page
        $response = $this->actingAs($this->user)->get(route('store.create'));

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the create store form view
        $response->assertViewIs('stores.create');
    }

    /** @test */
    public function store_creates_store_and_redirects_to_index_on_success()
    {
        $this->actingAs($this->user);

        // Simulate valid form data
        $formData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        // Make a POST request to the store route
        $response = $this->actingAs($this->user)->post(route('store.store'), $formData);

        // Assert that the response redirects to the index route
        $response->assertRedirect(route('store.index'));

        // Assert that the store was created in the database
        $this->assertDatabaseHas('stores', $formData);

        // Assert that a success message is flashed to the session
        $response->assertSessionHas('success', 'Store created successfully.');
    }

    /** @test */
    public function store_handles_validation_errors()
    {
        // Simulate invalid form data (missing required fields)
        $invalidData = [];

        // Make a POST request to the store route
        $response = $this->actingAs($this->user)->post(route('store.store'), $invalidData);

        $response->assertRedirect()->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'description' => 'The description field is required.',
        ]);

        // Assert that validation errors are flashed to the session
        $response->assertSessionHasErrors(['title', 'description']);

        // Assert that the store was not created in the database
        $this->assertDatabaseCount('stores', 0);
    }
}
