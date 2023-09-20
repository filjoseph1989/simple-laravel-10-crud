<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Auth;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Retrieve logged-in user's stores, paginate, and chunk for view.
     */
    public function index()
    {
        $user = Auth::user();

        $perPage = 9;
        $stores = Store::where('user_id', $user->id)->paginate($perPage);
        $storeChunks = $stores->chunk(3);
        return view('stores.index', compact('stores', 'storeChunks'));
    }

    /**
     * Show the form for creating a new resource.
     * TODO complete this
     */
    public function create()
    {
        return view('stores.create');
    }

    /**
     * Validate, create Store if valid, redirect with success on success.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $store = Store::create($validatedData);

        return redirect()->route('stores.index')->with('success', 'Store created successfully.');
    }

    /**
     * Retrieve and display the logged-in user's store by ID.
     */
    public function show(string $id)
    {
        $user = Auth::user();

        // Find the store by ID that belongs to the logged-in user
        $store = $user->stores()->findOrFail($id);

        return view('stores.show', compact('store'));
    }

    /**
     * Retrieve a store by ID and pass it to the 'stores.edit' view.
     */
    public function edit(string $id)
    {
        $store = Store::findOrFail($id);
        return view('stores.edit', compact('store'));
    }

    /**
     * Update store based on validated request data and redirect with success.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $store = Store::findOrFail($id);
        $store->update($validatedData);

        return redirect()->route('stores.index')->with('success', 'Store updated successfully.');
    }

    /**
     * Delete store by ID and redirect to index with success message.
     */
    public function destroy(string $id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('store.index')->with('success', 'Store deleted successfully.');
    }
}
