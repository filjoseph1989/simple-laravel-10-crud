<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use App\Models\UserStore;
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
        $response = $this->get(route('store.index'));
        $response->assertStatus(302);
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

    /** @test */
    public function show_displays_store_for_authenticated_user()
    {
        // Create a store associated with the user
        $store = Store::factory()->create(['user_id' => $this->user->id]);

        UserStore::create([
            'user_id' => $this->user->id,
            'store_id' => $store->id,
        ]);

        // Make a GET request to the store show route
        $response = $this->actingAs($this->user)->get(route('store.show', ['id' => $store->id]));

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the store details
        $response->assertSee($store->title);
        $response->assertSee($store->description);
    }

    /** @test */
    public function show_redirects_guest_users_to_index()
    {
        // Create a store
        $store = Store::factory()->create();

        // Make a GET request to the store show route as a guest user
        $response = $this->get(route('store.show', ['id' => $store->id]));

        // Assert that guest users are redirected to the index route
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function show_redirects_authenticated_users_to_index_for_non_owned_store()
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Authenticate the first user
        $this->actingAs($user1);

        // Create a store associated with the second user
        $store = Store::factory()->create(['user_id' => $user2->id]);

        // Make a GET request to the store show route for a non-owned store
        $response = $this->get(route('store.show', ['id' => $store->id]));

        // Assert that authenticated users are redirected to the index route for non-owned stores
        $response->assertRedirect(route('store.index'));
    }

    /** @test */
    public function edit_displays_edit_store_form_for_authenticated_user()
    {
        // Authenticate the user
        $this->actingAs($this->user);

        // Create a store associated with the user
        $store = Store::factory()->create(['user_id' => $this->user->id]);

        // Make a GET request to the store edit route
        $response = $this->get(route('store.edit', ['id' => $store->id]));

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the edit store form view
        $response->assertViewIs('stores.edit');

        // Assert that the response contains the store details
        $response->assertSee($store->title);
        $response->assertSee($store->description);
    }

    /** @test */
    public function edit_redirects_guest_users_to_index()
    {
        // Create a store
        $store = Store::factory()->create();

        // Make a GET request to the store edit route as a guest user
        $response = $this->get(route('store.edit', ['id' => $store->id]));

        // Assert that guest users are redirected to the index route
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function update_validates_form_data_including_uploaded_image()
    {
        // Create a store for the user.
        $store = Store::factory()->create([
            'user_id' => $this->user->id,
        ]);

        // Submit a request with invalid data.
        $response = $this->actingAs($this->user)->put(route('store.update',['id' => $store->id]), [
            'title' => '',
            'description' => '',
            'image' => 'not-an-image',
        ]);

        // Assert that the user is redirected back to the store edit form with validation errors.
        $response->assertRedirect()->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'description' => 'The description field is required.',
        ]);
    }

    /** @test */
    public function update_updates_store_with_new_values_and_uploaded_image()
    {
        // Create a store for the user.
        $store = Store::factory()->create([
            'user_id' => $this->user->id,
        ]);

        // Submit a request with valid data.
        $response = $this->actingAs($this->user)->put(route('store.update', ['id' => $store->id]), [
            'title' => 'New title',
            'description' => 'New description',
        ]);

        // Assert that the user is redirected to the store show page with a success message.
        $response->assertRedirect(route('store.show', ['id' => $store->id]))->with('success', 'Store updated successfully.');

        // Assert that the store has been updated.
        $store = $store->fresh();
        $this->assertEquals('New title', $store->title);
        $this->assertEquals('New description', $store->description);
    }

    /** @test */
    public function destroy_deletes_store_and_redirects_to_index_page()
    {
        // Create a store for the user.
        $store = Store::factory()->create([
            'user_id' => $this->user->id,
        ]);

        // Submit a request to delete the store.
        $response = $this->actingAs($this->user)->delete(route('store.destroy', ['id' => $store->id]));

        // Assert that the user is redirected to the store index page with a success message.
        $response->assertRedirect(route('store.index'))->with('success', 'Store deleted successfully.');

        // Assert that the store has been deleted.
        $store = Store::find($store->id);
        $this->assertNull($store);
    }

    private function getTestImage(): \Illuminate\Http\UploadedFile
    {
        return \Illuminate\Http\UploadedFile::fake()->image('test.jpg');
    }

    private function getTestImageName(): string
    {
        return time() . '_' . $this->getTestImage()->getClientOriginalName();
    }
}
