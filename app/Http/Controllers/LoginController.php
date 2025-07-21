<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function toLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect('/')->with('success', 'Bienvenue ' . $user->name);
        }

        return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Déconnexion réussie.');
    }
}
