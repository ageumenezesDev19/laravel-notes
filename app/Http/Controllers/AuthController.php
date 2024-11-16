<?php

namespace App\Http\Controllers;

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
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            [
                'text_username.required' => 'The username is required',
                'text_username.email' => 'The username must be a valid email',
                'text_password.required' => 'The password is required',
                'text_password.min' => 'The password requires at least :min characters',
                'text_password.max' => 'The password can have only a maximum of :max characters',
            ]
        );

        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // Test database connection
        try {
            DB::connection()->getPdo();
            // Return a success message
            return response()->json(['message' => 'Connection is OK!']);
        } catch (\PDOException $e) {
            // Return an error message with the exception message
            return response()->json(['error' => 'Connection failed: ' . $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        // Handle logout
        return response()->json(['message' => 'Logout successful']);
    }
}
