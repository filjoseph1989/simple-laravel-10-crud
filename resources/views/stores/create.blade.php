@extends('master')

@section('title', 'Create New Store')

@section('styles')
@endsection

@section('content')
    <div class="flex flex-row justify-center my-10">
        <h1 class="text-base font-bold mx-4 mt-4" style=" font-size: x-large;">Create New Store</h1>
    </div>

    <div class="flex flex-row justify-center">
        <div class="bg-zinc-800 flex justify-center w-1/2">
            <div class="w-full p-4">
                <form action="{{ route('store.store') }}" method="post">
                    @csrf
                    <div class="flex flex-col space-y-4">
                        <div class="flex flex-row items-center">
                            <label for="title" class="text-white mr-2 capitalize">title</label>
                            <input type="text" name="title" placeholder="new store name" class="w-full border rounded p-2">
                        </div>
                        <div class="flex flex-row items-center">
                            <label for="description" class="text-white mr-2 capitalize">description</label>
                            <input type="text" name="description" placeholder="new store description" class="w-full border rounded p-2">
                        </div>
                        <div class="flex flex-row items-center">
                            <label for="image" class="text-white mr-2 capitalize">Upload Image</label>
                            <input type="file" name="image" id="image" accept="image/*" class="w-full border rounded p-2">
                        </div>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
