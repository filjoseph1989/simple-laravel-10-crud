@extends('master')

@section('title', 'User Login Form')

@section('styles')
@endsection

@section('content')
    <h1 class="text-base font-bold" style=" font-size: x-large; margin: 40px 50px;">Login Form</h1>
    <div style="margin: 0 50px;">
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="flex flex-col space-y-4">
                <div class="flex flex-row items-center">
                    <label for="email" class="mr-2 w-[5em]">Email</label>
                    <input type="email" name="email" placeholder="email" class="w-full border rounded p-2">
                </div>
                <div class="flex flex-row items-center">
                    <label for="password" class="mr-2 w-[5em]">Password</label>
                    <input type="password" name="password" placeholder="Email" class="w-full border rounded p-2">
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Login</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection
