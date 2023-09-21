<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Store;
use App\Models\UserStore;
use Illuminate\Http\Request;
use Log;

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
        $user = Auth::user();

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            // Todo - file validation goes here
        ]);

        try {
            $validatedData['user_id'] = $user->id;
            $store = Store::create($validatedData);
            UserStore::create([
                'user_id' => $user->id,
                'store_id' => $store->id,
            ]);
            return redirect()->route('store.index')->with('success', 'Store created successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withError('An error occurred while saving the store.');
        }
    }

    /**
     * Retrieve and display the logged-in user's store by ID.
     */
    public function show(string $id)
    {
        $user = Auth::user();

        $store = UserStore::where('user_id', $user->id)
            ->where('store_id', $id)
            ->with('store')
            ->first();

        if ($store) {
            $store = $store->store;
            return view('stores.show', compact('store'));
        }

        return redirect()->route('store.index');
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            $store = Store::findOrFail($id);

            $store->title = $request->input('title');
            $store->description = $request->input('description');

            if ($request->hasFile('image')) {
                // Doing this to allow optional upload of the image
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $store->image = $imageName;
            }

            $store->save();

            return redirect()->route('store.show', ['id' => $store->id])->with('success', 'Store updated successfully.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->withError('An error occurred.');
        }
    }

    /**
     * Delete store by ID and redirect to index with success message.
     */
    public function destroy(string $id)
    {
        try {
            $store = Store::findOrFail($id);
            $store->delete();
            return redirect()->route('store.index')->with('success', 'Store deleted successfully.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->withError('An error occurred.');
        }
    }
}
