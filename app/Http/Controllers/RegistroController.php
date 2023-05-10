<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function index()
    {
        return view("registro");
    }

    public function registro(Request $request)
    {
        $request->validate([
            "nombre" => "required|min:4",
            "correo" => "required|email|unique:visitantes,correo|unique:users,correo",
            "password" => "required|min:4|confirmed",
            "password_confirmation" => "required|min:4"
        ]);

        DB::beginTransaction();
        try {
            $nuevo_usuario = User::create([
                "usuario" => $request->correo,
                "nombre" => mb_strtoupper($request->nombre),
                "password" => Hash::make($request->password),
                "correo" => $request->correo,
                "fecha_registro" => date("Y-m-d"),
                "tipo" => "VISITANTE",
                "acceso" => 1,
            ]);

            $visitante = $nuevo_usuario->visitante()->create([
                "nombre" => mb_strtoupper($request->nombre),
                "correo" => $request->correo,
                "fecha_registro" => date("Y-m-d"),
                "estado" => 1
            ]);


            // if (Auth::guard('visitantes')->attempt(['correo' => $visitante->correo, 'password' => $request->password])) {
            //     DB::commit();
            //     return response()->JSON(true);
            // }

            $res = Auth::attempt(['usuario' => $nuevo_usuario->correo, 'password' => $request->password, 'acceso' => 1]);
            if ($res) {
                DB::commit();
                return response()->JSON(true);
            }
        } catch (\Exception $e) {
            return response()->JSON(["message" => $e->getMessage()], 500);
        }
    }

    public function logout_visitante()
    {
        // Auth::guard('visitantes')->logout();
        Auth::logout();
        return redirect()->back();
    }
}
