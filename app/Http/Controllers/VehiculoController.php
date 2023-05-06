<?php

namespace App\Http\Controllers;

use App\Models\HistorialAccion;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehiculoController extends Controller
{
    public $validacion = [
        'marca_id' => 'required',
        'tipo_id' => 'required',
        'anio_id' => 'required',
        'modelo_id' => 'required',
        'descripcion' => 'required|min:4',
    ];

    public $mensajes = [];

    public function index(Request $request)
    {
        $vehiculos = Vehiculo::with("marca")->with("tipo")->with("anio")->with("modelo")->get();
        return response()->JSON(['vehiculos' => $vehiculos, 'total' => count($vehiculos)], 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);

        DB::beginTransaction();
        try {
            // crear Vehiculo
            $request["fecha_registro"] = date("Y-m-d");
            $nuevo_vehiculo = Vehiculo::create(array_map('mb_strtoupper', $request->except("imagen")));
            $nuevo_vehiculo->imagen = NULL;
            if ($request->hasFile("imagen")) {
                $imagen = $request->file("imagen");
                $extension = $imagen->getClientOriginalExtension();
                $nombre_imagen = time() . $nuevo_vehiculo->id . "." . $extension;
                $nuevo_vehiculo->imagen = $nombre_imagen;
                $imagen->move(public_path() . "/imgs/vehiculos", $nombre_imagen);
            }
            $nuevo_vehiculo->save();

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_vehiculo, "vehiculos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UN VEHICULO',
                'datos_original' => $datos_original,
                'modulo' => 'VEHICULOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'vehiculo' => $nuevo_vehiculo,
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

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $request->validate($this->validacion, $this->mensajes);

        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($vehiculo, "vehiculos");
            $vehiculo->update(array_map('mb_strtoupper', $request->except("imagen")));
            if ($request->hasFile("imagen")) {
                if ($vehiculo->imagen != NULL) {
                    \File::delete(public_path() . "/imgs/vehiculos/" . $vehiculo->imagen);
                }
                $imagen = $request->file("imagen");
                $extension = $imagen->getClientOriginalExtension();
                $nombre_imagen = time() . $vehiculo->id . "." . $extension;
                $vehiculo->imagen = $nombre_imagen;
                $imagen->move(public_path() . "/imgs/vehiculos", $nombre_imagen);
            }
            $vehiculo->save();

            $datos_nuevo = HistorialAccion::getDetalleRegistro($vehiculo, "vehiculos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' MODIFICÓ UN VEHICULO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'VEHICULOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'vehiculo' => $vehiculo,
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

    public function show(Vehiculo $vehiculo)
    {
        return response()->JSON([
            'sw' => true,
            'vehiculo' => $vehiculo
        ], 200);
    }

    public function destroy(Vehiculo $vehiculo)
    {
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($vehiculo, "vehiculos");
            if ($vehiculo->imagen != NULL) {
                \File::delete(public_path() . "/imgs/vehiculos/" . $vehiculo->imagen);
            }
            $vehiculo->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UN VEHICULO',
                'datos_original' => $datos_original,
                'modulo' => 'VEHICULOS',
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
