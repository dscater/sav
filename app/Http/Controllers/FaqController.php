<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\HistorialAccion;
use App\Models\VistaFecha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public $validacion = [
        'vehiculo_id' => 'required',
        'caracteristica_id' => 'required',
        'pregunta' => 'required',
        'respuesta' => 'required',
    ];

    public $mensajes = [];

    public function index(Request $request)
    {
        $faqs = Faq::with("vehiculo")->with("caracteristica_vehiculo")->get();
        return response()->JSON(['faqs' => $faqs, 'total' => count($faqs)], 200);
    }

    public function getFaqs(Request $request)
    {
        $marca_id = $request->marca_id;
        $modelo_id = $request->modelo_id;
        $tipo_id = $request->tipo_id;
        $anio_id = $request->anio_id;

        $faqs = Faq::with("vehiculo")
            ->with("caracteristica_vehiculo")
            ->select("faqs.*")
            ->join("vehiculos", "vehiculos.id", "=", "faqs.vehiculo_id");
        if ($marca_id != "") {
            $faqs->where("marca_id", $marca_id);
        }
        if ($modelo_id != "") {
            $faqs->where("modelo_id", $modelo_id);
        }
        if ($tipo_id != "") {
            $faqs->where("tipo_id", $tipo_id);
        }
        if ($anio_id != "") {
            $faqs->where("anio_id", $anio_id);
        }
        $faqs = $faqs->orderBy("vistas", "desc")->get();

        return response()->JSON(["listado" => $faqs]);
    }

    public function incrementaVistas(Faq $faq)
    {
        DB::beginTransaction();
        try {
            $fecha = date("Y-m-d");
            $vista_fecha = VistaFecha::where("faq_id", $faq->id)
                ->where("fecha", $fecha)
                ->get()->first();
            if (!$vista_fecha) {
                $vista_fecha = $faq->vista_fechas()->create([
                    "vistas" => 0,
                    "fecha" => $fecha
                ]);
            }
            $vista_fecha->vistas = (int)$vista_fecha->vistas + 1;
            $vista_fecha->save();
            $faq->vistas = (int)$faq->vistas + 1;
            $faq->save();
            DB::commit();
            return response()->JSON([
                "faq" => $faq
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);

        DB::beginTransaction();
        try {
            // crear Faq
            $request["fecha_registro"] = date("Y-m-d");
            $request["vistas"] = 0;
            $nuevo_faq = Faq::create([
                "vehiculo_id" => $request->vehiculo_id,
                "caracteristica_id" => $request->caracteristica_id,
                "pregunta" => mb_strtoupper($request->pregunta),
                "respuesta" => $request->respuesta,
                "fecha_registro" => $request->fecha_registro,
                "vistas" => 0
            ]);

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_faq, "faqs");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UN TIPO',
                'datos_original' => $datos_original,
                'modulo' => 'TIPOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'faq' => $nuevo_faq,
                'msj' => 'El registro se realizó de forma correcta',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate($this->validacion, $this->mensajes);

        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($faq, "faqs");
            $faq->update([
                "vehiculo_id" => $request->vehiculo_id,
                "caracteristica_id" => $request->caracteristica_id,
                "pregunta" => mb_strtoupper($request->pregunta),
                "respuesta" => $request->respuesta,
            ]);

            $datos_nuevo = HistorialAccion::getDetalleRegistro($faq, "faqs");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' MODIFICÓ UN TIPO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'TIPOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'faq' => $faq,
                'msj' => 'El registro se actualizó de forma correcta'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Faq $faq)
    {
        return response()->JSON([
            'sw' => true,
            'faq' => $faq
        ], 200);
    }

    public function destroy(Faq $faq)
    {
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($faq, "faqs");
            $faq->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UN TIPO',
                'datos_original' => $datos_original,
                'modulo' => 'TIPOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'msj' => 'El registro se eliminó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
