<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\Visitante;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getChatVisitante(Request $request)
    {
        $id = $request->id;
        $visitante = Visitante::findOrFail($id);

        $chats = Chat::where("visitante_id", $visitante->id)->with("visitante")->with("emisor")->with("receptor")->get();

        return response()->JSON([
            "mensajes" => $chats,
            "visitante" => $visitante->load("user")
        ]);
    }

    public function index()
    {
    }

    public function store(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $visitante = Visitante::findOrFail($request->visitante_id);
        $datos = [];
        if ($user->id == $visitante->user_id) {
            $datos = [
                "visitante_id" => $visitante->id,
                "emisor_id" => $user->id,
                "receptor_id" => null,
                "mensaje" => $request->mensaje,
                "fecha" => date("Y-m-d"),
                "hora" => date("H:i"),
                "estado" => "ENVIADO"
            ];
        } else {
            $datos = [
                "visitante_id" => $visitante->id,
                "emisor_id" => $user->id,
                "receptor_id" => $visitante->user_id,
                "mensaje" => $request->mensaje,
                "fecha" => date("Y-m-d"),
                "hora" => date("H:i"),
                "estado" => "ENVIADO"
            ];
        }

        $nuevo_mensaje = Chat::create($datos);

        return response()->JSON([
            "sw" => true,
            "nuevo_mensaje" => $nuevo_mensaje->load("emisor")->load("receptor")
        ]);
    }

    public function update(Chat $chat, Request $request)
    {
    }

    public function show(Chat $chat)
    {
    }

    public function destroy(Chat $chat)
    {
    }
}
