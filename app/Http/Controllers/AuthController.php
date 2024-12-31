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

        // check if users exists
        $user = User::where('username', $username)
                ->where('deleted_at', NULL)
                ->first();

        if(!$user) {
            return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'loginError',
                        'Username or password is incorrect'
                    );
        }

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
        //update last login
        $user_last_login = date('Y-m-d H:i:s');
        $user->save();

        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ]
        ]);

        // redirect to home
        return redirect()->to('/');
    }

    public function logout()
    {
        // Handle logout
        session()->forget('user');
        return redirect()->to('/login');
    }
}
