<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body>
    <h1>Registration Form</h1>

    <form action="/register" method="post">
        @csrf

        <div class="flex flex-col space-y-4">
            <div class="flex flex-row items-center">
                <label for="name" class="mr-2">Name</label>
                <input type="text" name="name" placeholder="Name" class="w-full border rounded p-2">
            </div>
            <div class="flex flex-row items-center">
                <label for="email" class="mr-2">Email</label>
                <input type="email" name="email" placeholder="Email" class="w-full border rounded p-2">
            </div>
            <div class="flex flex-row items-center">
                <label for="password" class="mr-2">Password</label>
                <input type="password" name="password" placeholder="Password" class="w-full border rounded p-2">
            </div>
            <div class="flex flex-row items-center">
                <label for="password_confirmation" class="mr-2">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
        </div>

   </form>
</body>
</html>

