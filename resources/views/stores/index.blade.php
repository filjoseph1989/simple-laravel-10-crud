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

    <div class="flex flex-row mx-4">
        <a href="/store/create" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Create Store</a>
    </div>

    @foreach ($storeChunks as $chunks)
        <div class="flex flex-row justify-center">
            <div class="mx-2">
                <div class="flex columns-3">
                    @foreach ($chunks as $store)
                        <div class="mx-2 my-4 rounded-md w-1/3 ">
                            <div class="scale-100 p-6 bg-white dark:bg-gray-900 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                <div>
                                    <a href="{{ route('store.show', ['id' => $store->id]) }}" class="flex">
                                        <div>
                                            {{-- Todo - Add actual link on the stores table --}}
                                            @php $store->image = null; @endphp

                                            @if (is_null($store->image))
                                                <div class="h-16 w-16 bg-red-50 light:bg-gray-900 flex items-center justify-center rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        class="ml-2 w-7 h-7 stroke-red-500">
                                                        <path d="M12 2c2.2 0 4 1.8 4 4s-1.8 4-4 4-4-1.8-4-4 1.8-4 4-4zM12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
                                                        <path d="M20 18h-3.3c-.4 0-.7-.2-1.1-.4l-1.6-.8-1.8 3.6c-.3.7-1 1.2-1.8 1.2h-8c-1.1 0-2-.9-2-2v-12c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2z"/>
                                                    </svg>
                                                </div>
                                            @else
                                                <div> <img src="{{ $store->image }}" alt="Store image" class="w-full h-32"> </div>
                                            @endif

                                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ $store->title }}</h2>

                                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{ $store->description }}</p>
                                        </div>

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="mt-10">
                                    {{-- Todo - update the user link --}}
                                    <i class="text-white text-sm">
                                        <a href="http://{{ $store->user_id }}">{{ ucfirst($store->user->name) ?? 'Owner\'s Name' }}</a> | Created On
                                        {{ $store->created_at->format("M d, Y") }}
                                    </i>

                                    <div class="flex">
                                        <a href="{{ route('store.edit', ['id' => $store->id]) }}">
                                            <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded delete-btn mr-1">Edit</button>
                                        </a>
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
