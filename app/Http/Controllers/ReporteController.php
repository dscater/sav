<?php

namespace App\Http\Controllers;

use App\Models\CaracteristicaVehiculo;
use App\Models\DetalleOrden;
use App\Models\Faq;
use App\Models\HistorialAccion;
use App\Models\Vehiculo;
use App\Models\User;
use App\Models\Visitante;
use App\Models\VistaFecha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReporteController extends Controller
{
    public function usuarios(Request $request)
    {
        $filtro =  $request->filtro;
        $usuarios = User::where('id', '!=', 1)->where("tipo", "!=", "VISITANTE")->orderBy("paterno", "ASC")->get();

        if ($filtro == 'Tipo de usuario') {
            $request->validate([
                'tipo' => 'required',
            ]);
            $usuarios = User::where('id', '!=', 1)->where('tipo', $request->tipo)->orderBy("paterno", "ASC")->get();
        }

        $pdf = PDF::loadView('reportes.usuarios', compact('usuarios'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('Usuarios.pdf');
    }

    public function vehiculos(Request $request)
    {
        $filtro =  $request->filtro;
        $marca =  $request->marca;
        $tipo =  $request->tipo;
        $anio =  $request->anio;
        $modelo =  $request->modelo;
        $vehiculos = Vehiculo::all();

        if ($filtro != 'Todos') {
            $vehiculos = Vehiculo::select("vehiculos.*");
            if ($marca != 'Todos') {
                $vehiculos = $vehiculos->where("marca_id", $marca);
            }
            if ($tipo != 'Todos') {
                $vehiculos = $vehiculos->where("tipo_id", $tipo);
            }
            if ($anio != 'Todos') {
                $vehiculos = $vehiculos->where("anio_id", $anio);
            }
            if ($modelo != 'Todos') {
                $vehiculos = $vehiculos->where("modelo_id", $modelo);
            }
            $vehiculos = $vehiculos->get();
        }

        $pdf = PDF::loadView('reportes.vehiculos', compact('vehiculos'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('vehiculos.pdf');
    }

    public function visitantes(Request $request)
    {
        $filtro =  $request->filtro;
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $visitantes = Visitante::orderBy("nombre", "ASC")->get();

        if ($filtro == 'Rango de fechas') {
            $request->validate([
                'fecha_ini' => 'required|date',
                'fecha_fin' => 'required|date',
            ]);
            $visitantes = Visitante::whereBetween('fecha_registro', [$fecha_ini, $fecha_fin])->orderBy("nombre", "ASC")->get();
        }

        $pdf = PDF::loadView('reportes.visitantes', compact('visitantes'))->setPaper('letter', 'potrait');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->download('visitantes.pdf');
    }

    public function historial_accion(Request $request)
    {
        $historial_accions = HistorialAccion::orderBy("created_at", "desc")->get();

        if (isset($request->fecha_ini) && isset($request->fecha_fin)) {
            $historial_accions = HistorialAccion::with("user")->whereBetween("fecha", [$request->fecha_ini, $request->fecha_fin])->orderBy("created_at", "desc")->get();
        }

        $pdf = PDF::loadView('reportes.historial_accion', compact('historial_accions'))->setPaper('legal', 'portrait');

        // ENUMERAR LAS PÁGINAS
        $pdf->setOption('footer-right', '[page]');
        return $pdf->download('historial_accions.pdf');
    }


    public function vistas(Request $request)
    {
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $filtro =  $request->filtro;
        $vehiculo_id =  $request->vehiculo_id;
        $vehiculos = Vehiculo::all();
        if ($filtro == 'Vehiculo') {
            $request->validate([
                "vehiculo_id" => "required",
            ], [
                "vehiculo_id.required" => "Debes seleccionar un vehículo"
            ]);
            $vehiculos = Vehiculo::select("vehiculos.*")
                ->where("id", $vehiculo_id)
                ->get();
        }
        $data = [];
        $categorias = [];

        // este array almacena la información por vehiculo
        $array_info_vehiculos = [];
        foreach ($vehiculos as $vehiculo) {
            $categorias[] = $vehiculo->full_name;
            $cant_faq_vehiculo = 0;
            if ($filtro == 'Rango de fechas') {
                $cant_faq_vehiculo = VistaFecha::select("vista_fechas.*")
                    ->join("faqs", "faqs.id", "=", "vista_fechas.faq_id")
                    ->where("faqs.vehiculo_id", $vehiculo->id)
                    ->whereBetween("vista_fechas.fecha", [$fecha_ini, $fecha_fin])
                    ->sum("vista_fechas.vistas");
            } else {
                $cant_faq_vehiculo = Faq::where("vehiculo_id", $vehiculo->id)
                    ->sum("vistas");
            }
            $array_info_vehiculos[] = (int)$cant_faq_vehiculo;
        }

        $caracteristicas = CaracteristicaVehiculo::all();
        // armar por caracteristicas
        foreach ($caracteristicas as $carac) {
            // este array almacena la información por caracteristica
            $array_info_caracteristicas = [];
            foreach ($vehiculos as $vehiculo) {
                $cant_faq_caracteristica = 0;
                if ($filtro == 'Rango de fechas') {
                    $cant_faq_caracteristica = VistaFecha::select("vista_fechas.*")
                        ->join("faqs", "faqs.id", "=", "vista_fechas.faq_id")
                        ->where("faqs.caracteristica_id", $carac->id)
                        ->where("faqs.vehiculo_id", $vehiculo->id)
                        ->whereBetween("vista_fechas.fecha", [$fecha_ini, $fecha_fin])
                        ->sum("vista_fechas.vistas");
                } else {
                    $cant_faq_caracteristica = Faq::where("caracteristica_id", $carac->id)
                        ->where("vehiculo_id", $vehiculo->id)
                        ->sum("vistas");
                }
                $array_info_caracteristicas[] = (int)$cant_faq_caracteristica;
            }
            $data[] = [
                "type" => "column",
                "name" => $carac->caracteristica,
                "data" => $array_info_caracteristicas,
            ];
        }
        $data[] = [
            "type" => "spline",
            "name" => "Vistas por vehículo",
            "data" => $array_info_vehiculos,
            "marker" => [
                "lineWidth" => 2,
                "color" => "RED",
                "lineColor" => "RED",
                "fillColor" => "WHITE",
            ],
        ];

        $fecha = date("d/m/Y");
        return response()->JSON([
            "sw" => true,
            "datos" => $data,
            "categorias" => $categorias,
            "fecha" => $fecha
        ]);
    }
}
