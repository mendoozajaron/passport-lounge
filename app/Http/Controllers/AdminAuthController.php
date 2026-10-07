<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $creds = $request->validate(['email' => 'required|email', 'password' => 'required']);

        if (! Auth::attempt($creds)) {
            return response()->json(['message' => 'Wrong email or password.'], 422);
        }
        $request->session()->regenerate();

        return Auth::user()->only('name', 'email');
    }

    public function me()
{
    return response()->json(Auth::user()?->only('name', 'email'))
        ->header('Cache-Control', 'no-store');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
