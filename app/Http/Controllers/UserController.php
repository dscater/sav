<?php

namespace App\Http\Controllers;

use App\Models\CaracteristicaVehiculo;
use App\Models\HistorialAccion;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $validacion = [
        'nombre' => 'required|min:4',
        'paterno' => 'required|min:4',
        'ci' => 'required|numeric|digits_between:4, 20|unique:users,ci',
        'ci_exp' => 'required',
        'correo' => 'required|email|unique:users,correo',
        'dir' => 'required|min:4',
        'fono' => 'required|min:1',
        'tipo' => 'required',
        'acceso' => 'required',
    ];

    public $mensajes = [
        'nombre.required' => 'Este campo es obligatorio',
        'nombre.min' => 'Debes ingressar al menos 4 carácteres',
        'paterno.required' => 'Este campo es obligatorio',
        'paterno.min' => 'Debes ingresar al menos 4 carácteres',
        'ci.required' => 'Este campo es obligatorio',
        'ci.numeric' => 'Debes ingresar un valor númerico',
        'ci.unique' => 'Este número de C.I. ya fue registrado',
        'ci_exp.required' => 'Este campo es obligatorio',
        'dir.required' => 'Este campo es obligatorio',
        'dir.min' => 'Debes ingresar al menos 4 carácteres',
        'fono.required' => 'Este campo es obligatorio',
        'fono.min' => 'Debes ingresar al menos 4 carácteres',
        'cel.required' => 'Este campo es obligatorio',
        'cel.min' => 'Debes ingresar al menos 4 carácteres',
        'tipo.required' => 'Este campo es obligatorio',
        'correo' => 'nullable|email|unique:users,correo',
    ];

    public $permisos = [
        'ADMINISTRADOR' => [
            'usuarios.index',
            'usuarios.create',
            'usuarios.edit',
            'usuarios.destroy',
            'reemplazar_password',

            'faqs.index',
            'faqs.create',
            'faqs.edit',
            'faqs.destroy',

            'chats.index',
            'chats.create',
            'chats.edit',
            'chats.destroy',

            'vehiculos.index',
            'vehiculos.create',
            'vehiculos.edit',
            'vehiculos.destroy',

            'caracteristica_vehiculos.index',
            'caracteristica_vehiculos.create',
            'caracteristica_vehiculos.edit',
            'caracteristica_vehiculos.destroy',

            'modelos.index',
            'modelos.create',
            'modelos.edit',
            'modelos.destroy',

            'marcas.index',
            'marcas.create',
            'marcas.edit',
            'marcas.destroy',

            'tipos.index',
            'tipos.create',
            'tipos.edit',
            'tipos.destroy',

            'anios.index',
            'anios.create',
            'anios.edit',
            'anios.destroy',

            'visitantes.index',
            'visitantes.create',
            'visitantes.edit',
            'visitantes.destroy',

            'configuracion.index',
            'configuracion.edit',

            'reportes.usuarios',
            'reportes.vehiculos',
            'reportes.visitantes',
            'reportes.vistas',
        ],
        'MECÁNICO' => [
            'faqs.index',
            'faqs.create',
            'faqs.edit',
            'faqs.destroy',

            'chats.index',
            'chats.create',
            'chats.edit',
            'chats.destroy',

            'vehiculos.index',
            'vehiculos.create',
            'vehiculos.edit',
            'vehiculos.destroy',

            'caracteristica_vehiculos.index',
            'caracteristica_vehiculos.create',
            'caracteristica_vehiculos.edit',
            'caracteristica_vehiculos.destroy',

            'modelos.index',
            'modelos.create',
            'modelos.edit',
            'modelos.destroy',

            'marcas.index',
            'marcas.create',
            'marcas.edit',
            'marcas.destroy',

            'tipos.index',
            'tipos.create',
            'tipos.edit',
            'tipos.destroy',

            'anios.index',
            'anios.create',
            'anios.edit',
            'anios.destroy',

            'visitantes.index',
            'visitantes.create',
            'visitantes.edit',
            'visitantes.destroy',

            'reportes.vehiculos',
            'reportes.visitantes',
            'reportes.vistas',
        ],
        'VISITANTE' => [],
    ];


    public function index(Request $request)
    {
        $usuarios = User::where('id', '!=', 1)->where("tipo", "!=", "VISITANTE")->get();
        return response()->JSON(['usuarios' => $usuarios, 'total' => count($usuarios)], 200);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }

        $request->validate($this->validacion, $this->mensajes);
        $request['password'] = 'NoNulo';
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear el Usuario
            $request["usuario"] = mb_strtolower($request->correo);
            $nuevo_usuario = User::create(array_map('mb_strtoupper', $request->except('foto')));
            $nuevo_usuario->password = Hash::make($request->ci);
            $nuevo_usuario->save();
            $nuevo_usuario->foto = 'default.png';
            if ($request->hasFile('foto')) {
                $file = $request->foto;
                $nom_foto = time() . '_' . $nuevo_usuario->usuario . '.' . $file->getClientOriginalExtension();
                $nuevo_usuario->foto = $nom_foto;
                $file->move(public_path() . '/imgs/users/', $nom_foto);
            }
            $nuevo_usuario->correo = mb_strtolower($nuevo_usuario->correo);
            $nuevo_usuario->usuario = mb_strtolower($nuevo_usuario->correo);
            $nuevo_usuario->save();

            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_usuario, "users");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' REGISTRO UN USUARIO',
                'datos_original' => $datos_original,
                'modulo' => 'USUARIOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'usuario' => $nuevo_usuario,
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

    public function update(Request $request, User $usuario)
    {
        $this->validacion['ci'] = 'required|min:4|numeric|unique:users,ci,' . $usuario->id;
        $this->validacion['correo'] = 'required|email|unique:users,correo,' . $usuario->id;
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpeg,jpg,png|max:2048';
        }
        if ($request->tipo == 'CAJA') {
            $this->validacion['caja_id'] = 'required';
        }

        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($usuario, "users");
            $usuario->update(array_map('mb_strtoupper', $request->except('foto')));
            if ($usuario->correo == "") {
                $usuario->correo = NULL;
            }

            if ($request->hasFile('foto')) {
                $antiguo = $usuario->foto;
                if ($antiguo != 'default.png') {
                    \File::delete(public_path() . '/imgs/users/' . $antiguo);
                }
                $file = $request->foto;
                $nom_foto = time() . '_' . $usuario->usuario . '.' . $file->getClientOriginalExtension();
                $usuario->foto = $nom_foto;
                $file->move(public_path() . '/imgs/users/', $nom_foto);
            }
            $usuario->correo = mb_strtolower($usuario->correo);
            $usuario->usuario = mb_strtolower($usuario->correo);
            $usuario->save();

            $datos_nuevo = HistorialAccion::getDetalleRegistro($usuario, "users");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' MODIFICÓ UN USUARIO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'USUARIOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                'sw' => true,
                'usuario' => $usuario,
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

    public function show(User $usuario)
    {
        return response()->JSON([
            'sw' => true,
            'usuario' => $usuario
        ], 200);
    }

    public function actualizaContrasenia(User $usuario, Request $request)
    {
        $request->validate([
            'password_actual' => ['required', function ($attribute, $value, $fail) use ($usuario, $request) {
                if (!\Hash::check($request->password_actual, $usuario->password)) {
                    return $fail(__('La contraseña no coincide con la actual.'));
                }
            }],
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4'
        ]);


        DB::beginTransaction();
        try {
            $usuario->password = Hash::make($request->password);
            $usuario->save();
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'msj' => 'La contraseña se actualizó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function actualizaFoto(User $usuario, Request $request)
    {
        DB::beginTransaction();
        try {

            if ($request->hasFile('foto')) {
                $antiguo = $usuario->foto;
                if ($antiguo != 'default.png') {
                    \File::delete(public_path() . '/imgs/users/' . $antiguo);
                }
                $file = $request->foto;
                $nom_foto = time() . '_' . $usuario->usuario . '.' . $file->getClientOriginalExtension();
                $usuario->foto = $nom_foto;
                $file->move(public_path() . '/imgs/users/', $nom_foto);
            }
            $usuario->save();
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'usuario' => $usuario,
                'msj' => 'Foto actualizada con éxito'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'sw' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(User $usuario)
    {
        DB::beginTransaction();
        try {
            $antiguo = $usuario->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/users/' . $antiguo);
            }

            $usuario->chat_emisor()->delete();
            $usuario->chat_receptor()->delete();

            $datos_original = HistorialAccion::getDetalleRegistro($usuario, "users");
            $usuario->delete();

            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->usuario . ' ELIMINÓ UN USUARIO',
                'datos_original' => $datos_original,
                'modulo' => 'USUARIOS',
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

    public function getPermisos(User $usuario, Request $request)
    {
        $tipo = $usuario->tipo;
        return response()->JSON($this->permisos[$tipo]);
    }

    public function getInfoBox()
    {
        $tipo = Auth::user()->tipo;
        $array_infos = [];
        if (in_array('usuarios.index', $this->permisos[$tipo])) {
            $array_infos[] = [
                'label' => 'Usuarios',
                'cantidad' => count(User::where('id', '!=', 1)->where("tipo", "!=", "VISITANTE")->get()),
                'color' => 'bg-info',
                'icon' => 'fas fa-users',
            ];
        }
        if (in_array('vehiculos.index', $this->permisos[$tipo])) {
            $array_infos[] = [
                'label' => 'Vehículos',
                'cantidad' => count(Vehiculo::all()),
                'color' => 'bg-primary',
                'icon' => 'fa fa-car',
            ];
        }
        if (in_array('caracteristica_vehiculos.index', $this->permisos[$tipo])) {
            $array_infos[] = [
                'label' => 'Caracteristicas de vehículos',
                'cantidad' => count(CaracteristicaVehiculo::all()),
                'color' => 'bg-info',
                'icon' => 'fas fa-list-alt',
            ];
        }
        if (in_array('visitantes.index', $this->permisos[$tipo])) {
            $array_infos[] = [
                'label' => 'Visitantes',
                'cantidad' => count(Visitante::all()),
                'color' => 'bg-warning',
                'icon' => 'fas fa-users',
            ];
        }

        return response()->JSON($array_infos);
    }

    public function userActual()
    {
        return response()->JSON(Auth::user());
    }

    public function getUsuario(User $usuario)
    {
        return response()->JSON($usuario);
    }

    public function reemplaza_password(User $usuario, Request $request)
    {
        $request->validate([
            "password" => "required"
        ], [
            "password.required" => "Debes ingresar un valor"
        ]);
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return response()->JSON([
            "sw" => true
        ]);
    }
}
