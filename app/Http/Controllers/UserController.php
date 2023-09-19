<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Log;

class UserController extends Controller
{
    /**
     * function to register a user
     *
     * @param Request $request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Send a confirmation email to the user.

            return redirect('/login');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->withError('An error occurred.');
        }
    }
}
