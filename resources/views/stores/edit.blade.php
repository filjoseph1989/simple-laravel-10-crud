@extends('master')

@section('title', 'Edit Store')

@section('styles')
@endsection

@section('content')
    <h1 class="text-base font-bold" style=" font-size: x-large; margin: 40px 50px;">Create Store Form</h1>
    <div style="margin: 0 50px;">
        <form action="{{ route('store.update', ['id' => $store->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col space-y-4">
                <div class="flex flex-row items-center">
                    <label for="title" class="mr-2 w-[10em]">Title</label>
                    <input type="text" name="title" placeholder="title" class="w-full border rounded p-2" value="{{ $store->title }}">
                </div>
                <div class="flex flex-row items-center">
                    <label for="description" class="mr-2 w-[10em]">Description</label>
                    <input type="text" name="description" placeholder="description" class="w-full border rounded p-2" value="{{ $store->description }}">
                </div>
                <div class="flex flex-row items-center">
                    <label for="image" class="w-[10em]">Upload Image</label>
                    <input type="file" name="image" id="image" class="border rounded p-2">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection
