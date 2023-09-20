<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stores</title>
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body>
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
    <h1 class="text-base font-bold mx-4 mt-4" style=" font-size: x-large;">Stores</h1>

    @foreach ($stores as $storeChunks)
        <div class="mx-2 my-2">
            <div class="flex columns-3">
                @foreach ($storeChunks as $store)
                    <div class="border mx-2 my-4 p-4 rounded-md">
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
                                <button type="button"
                                    class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</body>
</html>