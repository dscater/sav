<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getChatVisitante(Request $request)
    {
        $id = $request->id;
        $visitante = Visitante::findOrFail($id);

        $chats = Chat::where("visitante_id", $visitante->id)->with("visitante")->with("emisor")->with("receptor")->get();
        if (Auth::user()->tipo != 'VISITANTE') {
            // SI NO ES VISITANTE MARCAR COMO RECIBIDOS
            $visitante->chats()->where("receptor_id", null)->update(["estado" => "RECIBIDO"]);
        }

        if (Auth::user()->tipo == 'VISITANTE') {
            $sin_leer = count(Chat::where("visitante_id", $visitante->id)->where("receptor_id", $visitante->user_id)->where("estado", "ENVIADO")->get());
        } else {
            $sin_leer = count(Chat::where("receptor_id", null)->where("estado", "ENVIADO")->get());
        }
        return response()->JSON([
            "mensajes" => $chats,
            "visitante" => $visitante->load("user"),
            "sin_leer" => $sin_leer
        ]);
    }

    public function getNuevosMensajes(Request $request)
    {
        $id = $request->id;
        $ultimo_chat_id = $request->ultimo_chat_id;
        $activo = $request->activo;
        $visitante = Visitante::findOrFail($id);
        if (Auth::user()->tipo == 'VISITANTE') {
            if ($activo == 'si') {
                $visitante->chats()->where("receptor_id", Auth::user()->id)->update(["estado" => "RECIBIDO"]);
            }
            $sin_leer = count(Chat::where("visitante_id", $visitante->id)->where("receptor_id", $visitante->user_id)->where("estado", "ENVIADO")->get());
        } else {
            if ($activo == 'si') {
                $visitante->chats()->where("receptor_id", null)->update(["estado" => "RECIBIDO"]);
            }
            $sin_leer = count(Chat::where("receptor_id", null)->where("estado", "ENVIADO")->get());
        }
        $chats = Chat::where("visitante_id", $visitante->id)->where("id", ">", $ultimo_chat_id)->with("visitante")->with("emisor")->with("receptor")->get();
        return response()->JSON([
            "mensajes" => $chats,
            "visitante" => $visitante->load("user"),
            "sin_leer" => $sin_leer
        ]);
    }

    public function getInfoChat(Request $request)
    {
        if (Auth::user()->tipo == 'VISITANTE') {
            $visitante = Auth::user()->visitante;
            $sin_leer = count(Chat::where("visitante_id", $visitante->id)->where("receptor_id", $visitante->user_id)->where("estado", "ENVIADO")->get());
        } else {
            $sin_leer = count(Chat::where("receptor_id", null)->where("estado", "ENVIADO")->get());
        }
        return response()->JSON([
            "sin_leer" => $sin_leer
        ]);
    }

    public function actualizaEstadoChats(Request $request)
    {
        $tipo  = Auth::user()->tipo;
        if ($tipo != 'VISITANTE') {
            $visitante = Visitante::find($request->id);
            // SI NO ES VISITANTE MARCAR COMO RECIBIDOS
            $visitante->chats()->where("receptor_id", null)->update(["estado" => "RECIBIDO"]);
        } else {
            $visitante = Auth::user()->visitante;
            $visitante->chats()->where("receptor_id", Auth::user()->id)->update(["estado" => "RECIBIDO"]);
        }

        return response()->JSON(true);
    }

    public function verifica_estado_chat(Chat $chat, Request $request)
    {
        if ($chat->estado == 'RECIBIDO') {
            return response()->JSON(true);
        }
        return response()->JSON(false);
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
