<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // Validate the request
        $request->validate(
            [
                'text_username' => 'required', // Remove email validation if it's not required
                'text_password' => 'required|min:6|max:16'
            ],
            [
                'text_username.required' => 'The username is required',
                'text_password.required' => 'The password is required',
                'text_password.min' => 'The password requires at least :min characters',
                'text_password.max' => 'The password can have only a maximum of :max characters',
            ]
        );

        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // Check if user exists
        $user = User::where('username', $username)
                    ->whereNull('deleted_at') // Ensure deleted_at is null
                    ->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username or password is incorrect');
        }

        // Check if the password is correct
       // check if password is correct
       if(!password_verify($password, $user->password)) {
        return redirect()
                ->back()
                ->withInput()
                ->with(
                    'loginError',
                    'Username or password is incorrect'
                );
        };

        // Update last login
        $user->last_login = now();
        $user->save();

        // Store session data
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ]
        ]);

        // Redirect to home
        return redirect()->to('/');
    }

    public function logout()
    {
        // Handle logout
        session()->forget('user');
        return redirect()->to('/login')->with('success', 'Successfully logged out.');
    }
}
