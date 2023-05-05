<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Recuperacion;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class CorreoController extends Controller
{
    public function correo()
    {
        return view("correo");
    }

    public function enviar(Request $request)
    {
        DB::beginTransaction();
        try {
            $existe_usuario = User::where("correo", trim($request->correo))->get()->first();
            if (!$existe_usuario) {
                throw new Exception("No se encontró ningun registro con ese correo electrónico");
            }
            $form_mail['emisor'] = [
                'correo' => Config::get('mail.from.address'),
                'nombre' => Configuracion::first()->razon_social,
                'asunto' => "Recuperación de contraseña"
            ];
            $form_mail['receptor'] = [
                'correo' => trim($request->correo)
            ];

            $existe_usuario->recuperacions()->update(["estado" => 0]);
            $nueva_recuperacion = $existe_usuario->recuperacions()->create([
                "correo" => $request->correo,
                "ci" => $request->ci,
                "estado" => 1
            ]);
            $datos_formulario = [
                'nombre' => $existe_usuario->full_name,
                'url' => route("recuperar_contrasena.nueva_contrasena", $nueva_recuperacion->id)
            ];

            Mail::send('mail', $datos_formulario, function ($msj) use ($form_mail) {
                $msj->from($form_mail['emisor']['correo'], mb_strtoupper($form_mail['emisor']['nombre']));
                $msj->subject($form_mail['emisor']['asunto']);
                $msj->to($form_mail['receptor']['correo']);
            });
            DB::commit();
            return redirect()->back()->with('success', 'El proceso se realizó con éxito. Revisa tu bandeja de entrada.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error.' . $e->getMessage());
        }
    }

    public function nueva_contrasena(Recuperacion $recuperacion)
    {
        return view("nueva_contrasena", compact("recuperacion"));
    }

    public function update(Recuperacion $recuperacion, Request $request)
    {

        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        DB::beginTransaction();
        try {
            if ($recuperacion->estado == 0) {
                throw new Exception("El link que utilizó ya no esta disponible para el reestablecimiento de contraseña");
            }
            $recuperacion->user->password = Hash::make($request->password);
            $recuperacion->user->save();
            $recuperacion->estado = 0;
            $recuperacion->save();
            DB::commit();
            return redirect()->back()->with('success', 'La contraseña se reestableció correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error.' . $e->getMessage());
        }
    }
}
