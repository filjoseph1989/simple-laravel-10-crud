<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Send a confirmation email to the user. for now set the now
            $user->email_verified_at = now();
            $user->save();

            return redirect('/login');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->withError('An error occurred.');
        }
    }

    /**
     * Validate user credentials and redirect to dashboard or display login error.
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        // Todo - solve the issue encountered 'page expire' when user enter wrong credentials
        return redirect('/login')
            ->withErrors(['email' => 'Invalid credentials'])
            ->withInput();
    }

    /**
     * Logout the user, invalidate session, and redirect to the home page.
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
