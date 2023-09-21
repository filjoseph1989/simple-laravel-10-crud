@extends('master')

@section('title', 'Store')

@section('styles')
@endsection

@section('content')
    <div class="flex flex-row justify-center my-10">
        <h1 class="text-base font-bold mx-4 mt-4" style=" font-size: x-large;">Store</h1>
    </div>

    <div class="flex flex-row justify-center">
        <div class="mx-2">
            <div class="flex columns-3">
                <div class="mx-2 my-4 rounded-md border">
                    <div class="bg-white rounded-lg shadow-lg">
                        <div class="p-4">
                            <img src="{{ $store->image }}" alt="Store image" class="w-full h-32">
                            <h2 class="text-xl font-bold mb-4">
                                <a href="http://">{{ $store->title }}</a>
                            </h2>
                            <i><a href="http://{{ $store->user_id }}">Owner</a> | {{ $store->created_at->format("M d, Y") }}</i>

                            <p>{{ implode(' ', array_slice(explode(' ', $store->description), 0, 10)) }}</p>

                            {{-- TODO - --}}
                            <button type="button"
                                class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Visit</button>
                            <button type="button"
                                class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                            <form action="{{ route('store.destroy', $store->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded delete-btn">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
