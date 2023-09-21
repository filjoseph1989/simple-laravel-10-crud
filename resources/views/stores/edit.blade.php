@extends('master')

@section('title', 'Edit Store')

@section('styles')
@endsection

@section('content')
    <div class="relative min-h-screen dark:bg-gray-900 selection:bg-red-500 pt-10">
        <div class="flex flex-row justify-center my-10">
            <h1 class="text-base font-bold mx-4 mt-4" style=" font-size: x-large;">Edit Store</h1>
        </div>

        <div class="flex flex-row justify-center">
            <div class="bg-white rounded-lg shadow-lg w-1/2">
                <div class="p-4">
                    <form action="/" method="post">
                        @csrf
                        <div class="flex flex-col space-y-4">
                            <div class="flex flex-row items-center">
                                <label for="title" class="mr-2">Title</label>
                                <input type="text" name="title" placeholder="title" class="w-full border rounded p-2" value="{{ $store->title }}">
                            </div>
                            <div class="flex flex-row items-center">
                                <label for="description" class="mr-2">Description</label>
                                <input type="text" name="description" placeholder="description" class="w-full border rounded p-2" value="{{ $store->description }}">
                            </div>
                            <div class="flex flex-row items-center">
                                <label for="image" class="mr-2">Upload Image</label>
                                <input type="file" name="image" id="image" class="border rounded p-2">
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
