@extends('master')

@section('title', 'User Registration Form')

@section('styles')
@endsection

@section('content')
    <h1 class="text-base font-bold" style=" font-size: x-large; margin: 40px 50px;">Registration Form</h1>

    <div style="margin: 0 50px;">
        <form action="/register" method="post">
            @csrf

            <div class="flex flex-col space-y-4">
                <div class="flex flex-row items-center">
                    <label for="first-name" class="mr-2 w-[10em]">First Name</label>
                    <input type="text" name="first_name" placeholder="First Name" class="w-full border rounded p-2">
                </div>
                <div class="flex flex-row items-center">
                    <label for="last-name" class="mr-2 w-[10em]">Last Name</label>
                    <input type="text" name="last_name" placeholder="Last Name" class="w-full border rounded p-2">
                </div>
                <div class="flex flex-row items-center">
                    <label for="email" class="mr-2 w-[10em]">Email</label>
                    <input type="email" name="email" placeholder="Email" class="w-full border rounded p-2">
                </div>
                <div class="flex flex-row items-center">
                    <label for="password" class="mr-2 w-[10em]">Password</label>
                    <input type="password" name="password" placeholder="Password" class="w-full border rounded p-2">
                </div>
                <div class="flex flex-row items-center">
                    <label for="password_confirmation" class="mr-2 w-[10em]">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full border rounded p-2">
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection
