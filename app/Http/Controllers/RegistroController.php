<?php

namespace App\Http\Controllers;

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
            "correo" => "required|email|unique:visitantes,correo",
            "password" => "required|min:4|confirmed",
            "password_confirmation" => "required|min:4"
        ]);

        DB::beginTransaction();
        try {
            $visitante = Visitante::create([
                "nombre" => mb_strtoupper($request->nombre),
                "correo" => $request->correo,
                "password" => Hash::make($request->password),
                "fecha_registro" => date("Y-m-d"),
                "estado" => 1
            ]);


            if (Auth::guard('visitantes')->attempt(['correo' => $visitante->correo, 'password' => $request->password])) {
                DB::commit();
                return response()->JSON(true);
            }
        } catch (\Exception $e) {
            return response()->JSON(["message" => $e->getMessage()], 500);
        }
    }

    public function logout_visitante()
    {
        Auth::guard('visitantes')->logout();
        return redirect()->back();
    }
}
