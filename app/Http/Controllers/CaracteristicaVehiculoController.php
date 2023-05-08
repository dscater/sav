<?php

namespace App\Http\Controllers;

use App\Models\CaracteristicaVehiculo;
use App\Models\HistorialAccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CaracteristicaVehiculoController extends Controller
{
    public $validacion = [
        'caracteristica' => 'required|min:2',
    ];

    public $mensajes = [];

    public function index(Request $request)
    {
        $caracteristica_vehiculos = CaracteristicaVehiculo::all();
        return response()->JSON(['caracteristica_vehiculos' => $caracteristica_vehiculos, 'total' => count($caracteristica_vehiculos)], 200);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);

        DB::beginTransaction();
        try {
            // crear CaracteristicaVehiculo
            $request["fecha_registro"] = date("Y-m-d");
            $nuevo_caracteristica_vehiculo = CaracteristicaVehiculo::create(array_map('mb_strtoupper', $request->all()));

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_caracteristica_vehiculo, "caracteristica_vehiculos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UNA CARACTERISTICA DE VEHÍCULO',
                'datos_original' => $datos_original,
                'modulo' => 'CARACTERISTICA DE VEHICULOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'caracteristica_vehiculo' => $nuevo_caracteristica_vehiculo,
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

    public function update(Request $request, CaracteristicaVehiculo $caracteristica_vehiculo)
    {
        $request->validate($this->validacion, $this->mensajes);

        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($caracteristica_vehiculo, "caracteristica_vehiculos");
            $caracteristica_vehiculo->update(array_map('mb_strtoupper', $request->all()));

            $datos_nuevo = HistorialAccion::getDetalleRegistro($caracteristica_vehiculo, "caracteristica_vehiculos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' MODIFICÓ UNA CARACTERISTICA DE VEHÍCULO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'CARACTERISTICA DE VEHICULOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'caracteristica_vehiculo' => $caracteristica_vehiculo,
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

    public function show(CaracteristicaVehiculo $caracteristica_vehiculo)
    {
        return response()->JSON([
            'sw' => true,
            'caracteristica_vehiculo' => $caracteristica_vehiculo
        ], 200);
    }

    public function destroy(CaracteristicaVehiculo $caracteristica_vehiculo)
    {
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($caracteristica_vehiculo, "caracteristica_vehiculos");
            $caracteristica_vehiculo->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UNA CARACTERISTICA DE VEHÍCULO',
                'datos_original' => $datos_original,
                'modulo' => 'CARACTERISTICA DE VEHICULOS',
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
