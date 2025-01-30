<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'ci' => 'required',
            'password' => 'required',
            'captcha' => 'required',
        ], [
            'ci.required' => 'El nombre de usuario es requerido',
            'password.required' => 'La contraseña es requerida',
            'captcha.required' => 'El código de verificación es requerido',
        ]);

        if ($request->captcha !== Session::get('captcha')) {
            return back()->withErrors(['captcha' => 'El código de seguridad es incorrecto.']);
        }

        if (
            Auth::attempt(['ci' => $request->ci, 'password' => $request->password, 'remember_token' => $request->remember]) ||
            Auth::attempt(['email' => $request->ci, 'password' => $request->password, 'remember_token' => $request->remember])
        ) {
            if (Auth::user()->activo == false) {
                Auth::logout();
                return redirect()->back()->withErrors(['error' => 'Su cuenta se encuentra inactiva']);
            }

            session()->flash('message', 'Bienvenido/a de nuevo ' . Auth::user()->nombres . '!');
            return redirect()->route('inicio');
        }

        return redirect()->back()->withErrors(['error' => 'Credenciales incorrectas'])->with(['ci' => $request->ci]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'Sesión cerrada con éxito');
    }
}
