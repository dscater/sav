<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view("app");
    }

    public function login(Request $request)
    {
        $request->validate([
            "usuario" => "required|email",
            "password" => "required",
        ]);
        $usuario = $request->usuario;
        $password = $request->password;
        $tipo = $request->tipo;

        $res = Auth::attempt(['usuario' => $usuario, 'password' => $password, 'acceso' => 1]);
        if ($res) {
            return response()->JSON([
                'user' => Auth::user(),
            ], 200);
        }

        return response()->JSON([], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->JSON(['code' => 204], 204);
    }
}
