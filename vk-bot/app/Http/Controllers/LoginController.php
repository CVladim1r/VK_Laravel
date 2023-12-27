<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        $user = User::where('name', $credentials['name'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return redirect('/login')->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }

    public function addNewUser()
    {
    }
}
