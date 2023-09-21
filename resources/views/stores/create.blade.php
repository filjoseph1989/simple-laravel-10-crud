@extends('master')

@section('title', 'Create New Store')

@section('styles')
@endsection

@section('content')
    <h1 class="text-base font-bold" style=" font-size: x-large; margin: 40px 50px;">Create Store Form</h1>
    <div style="margin: 0 50px;">
        <form action="{{ route('store.store') }}" method="post">
            @csrf
            <div class="flex flex-col space-y-4">
                <div class="flex flex-row items-center">
                    <label for="title" class="mr-2 capitalize w-[8em]">title</label>
                    <input type="text" name="title" placeholder="new store name" class="w-full border rounded p-2">
                </div>
                <div class="flex flex-row items-center">
                    <label for="description" class="mr-2 capitalize w-[8em]">description</label>
                    <input type="text" name="description" placeholder="new store description" class="w-full border rounded p-2">
                </div>
                <div class="flex flex-row items-center">
                    <label for="image" class="mr-2 capitalize w-[8em]">Upload Image</label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full border rounded p-2">
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection
