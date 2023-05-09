<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Visitante;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getChatVisitante(Request $request)
    {
        $id = $request->id;
        $visitante = Visitante::findOrFail($id);

        $chats = Chat::where("visitante_id", $visitante->id)->with("emisor")->with("receptor")->get();

        return response()->JSON([
            "mensajes" => $chats,
            "visitante" => $visitante->load("user")
        ]);
    }
}
