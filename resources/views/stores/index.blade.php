@extends('master')

@section('title', 'List of Stores')

@section('styles')
@endsection

@section('content')
    {{--
        TODO
        1. find an actual image or generate one
        2. the links must be correct and has there own routes
        3. When mouse click on the store title or on the button or on the image, visit the store page
            - button
            - title
            - image
        4. When mouse click on the owner name, visit owners profile

        --}}
    <div class="flex flex-row justify-center mb-10">
        <h1 class="text-base font-bold mx-4 mt-4 text-white"
            style="font-size: x-large;">Stores</h1>
    </div>

    @foreach ($storeChunks as $chunks)
        <div class="flex flex-row justify-center">
            <div class="mx-2">
                <div class="flex columns-3">
                    @foreach ($chunks as $store)
                        <div class="mx-2 my-4 rounded-md border">
                            <div class="bg-white rounded-lg shadow-lg">
                                <div class="flex flex-col p-4">
                                    <div>
                                        <img src="{{ $store->image }}" alt="Store image" class="w-full h-32">
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold mb-4">
                                            <a href="http://">{{ $store->title }}</a>
                                        </h2>
                                        <i><a href="http://{{ $store->user_id }}">Owner</a> | {{ $store->created_at->format("M d, Y") }}</i>
                                        <p>{{ implode(' ', array_slice(explode(' ', $store->description), 0, 10)) }}</p>
                                    </div>

                                    {{-- TODO - --}}
                                    <div class="mt-4 flex flex-row">
                                        <a href="{{ route('store.show', ['id' => $store->id]) }}" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Visit</a>
                                        <a href="{{ route('store.edit', ['id' => $store->id]) }}" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
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
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <ul class="flex flex-row justify-center space-x-2 my-10">
        @if ($stores->onFirstPage())
            <li><span class="bg-gray-200 text-gray-600 font-bold py-2 px-4 rounded cursor-not-allowed">Previous</span></li>
        @else
            <li><a href="{{ $stores->previousPageUrl() }}" class="bg-white hover:bg-gray-100 text-gray-600 font-bold py-2 px-4 rounded">Previous</a></li>
        @endif

        @foreach ($stores->links()->elements[0] as $page => $url)
            @if ($page == $stores->currentPage())
                <li><span class="bg-gray-200 text-gray-600 font-bold py-2 px-4 rounded">{{ $page }}</span></li>
            @else
                <li><a href="{{ $url }}" class="bg-white hover:bg-gray-100 text-gray-600 font-bold py-2 px-4 rounded">{{ $page }}</a></li>
            @endif
        @endforeach

        @if ($stores->hasMorePages())
            <li><a href="{{ $stores->nextPageUrl() }}" class="bg-white hover:bg-gray-100 text-gray-600 font-bold py-2 px-4 rounded">Next</a></li>
        @else
            <li><span class="bg-gray-200 text-gray-600 font-bold py-2 px-4 rounded cursor-not-allowed">Next</span></li>
        @endif
    </ul>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (confirm('Are you sure you want to delete this store?')) {
                        // Submit the form when confirmed
                        button.closest('form').submit();
                    }
                });
            });
        });
    </script>
@endsection
