<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'El nombre de usuario es requerido',
            'password.required' => 'La contraseña es requerida'
        ]);

        if (
            Auth::attempt(['username' => $request->username, 'password' => $request->password, 'remember_token' => $request->remember]) ||
            Auth::attempt(['email' => $request->username, 'password' => $request->password, 'remember_token' => $request->remember])
        ) {
            if (Auth::user()->activo == false) {
                Auth::logout();
                return redirect()->back()->withErrors(['error' => 'Su cuenta se encuentra inactiva']);
            }
            return redirect()->route('inicio');
        }

        return redirect()->back()->withErrors(['error' => 'Credenciales incorrectas'])->with(['username' => $request->username]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'Sesión cerrada con éxito');
    }
}
