<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('register'); // Ou o nome correto da sua view de registro
    }

    public function registerSubmit(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'username' => 'required|unique:users|max:50',
            'password' => 'required|min:6|confirmed', // Ensure password_confirmation field exists in form
        ]);

        try {
            // Create the new user
            $user = new User();
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->save();

            // Log the user in immediately after registration
            Auth::login($user);

            // Redirect to home page with success message
            return redirect()->route('home')->with('success', 'Registration successful.');
        } catch (\Exception $e) {
            // Handle errors and redirect back with a failure message
            return back()->with('registrationError', 'Something went wrong, please try again.');
        }
    }
}
