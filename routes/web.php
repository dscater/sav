<?php

use App\Http\Controllers\AnioController;
use App\Http\Controllers\CaracteristicaVehiculoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HistorialAccionController;
use App\Http\Controllers\IngresoProductoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SalidaProductoController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\TipoIngresoController;
use App\Http\Controllers\TipoSalidaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;


// RECUPERAR CONTRASEÑA
Route::get('/recuperar_contrasena', [CorreoController::class, "correo"])->name("recuperar_contrasena");
Route::post('/recuperar_contrasena', [CorreoController::class, "enviar"])->name("recuperar_contrasena.enviar");
Route::get('/recuperar_contrasena/nueva_contrasena/{recuperacion}', [CorreoController::class, "nueva_contrasena"])->name("recuperar_contrasena.nueva_contrasena");
Route::put('/recuperar_contrasena/update/{recuperacion}', [CorreoController::class, "update"])->name("recuperar_contrasena.update");

// INICIO
Route::get('/', [InicioController::class, 'index'])->name("inicio");

// LOGIN
Route::get('/login', [LoginController::class, 'index'])->name("login");
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

// REGISTRO
Route::get('/registro', [RegistroController::class, 'index'])->name("registro");
Route::post('/registro', [RegistroController::class, 'registro']);
Route::post('/logout_visitante', [RegistroController::class, 'logout_visitante'])->name("logout_visitante");

// CONFIGURACIÓN
Route::get('/configuracion/getConfiguracion', [ConfiguracionController::class, 'getConfiguracion']);

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::post('/admin/configuracion/update', [ConfiguracionController::class, 'update']);

        // Usuarios
        Route::get('usuarios/getUsuario/{usuario}', [UserController::class, 'getUsuario']);
        Route::get('usuarios/userActual', [UserController::class, 'userActual']);
        Route::get('usuarios/getInfoBox', [UserController::class, 'getInfoBox']);
        Route::get('usuarios/getPermisos/{usuario}', [UserController::class, 'getPermisos']);
        Route::get('usuarios/getEncargadosRepresentantes', [UserController::class, 'getEncargadosRepresentantes']);
        Route::post('usuarios/actualizaContrasenia/{usuario}', [UserController::class, 'actualizaContrasenia']);
        Route::post('usuarios/actualizaFoto/{usuario}', [UserController::class, 'actualizaFoto']);
        Route::resource('usuarios', UserController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // Modelos
        Route::resource('modelos', ModeloController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // Marcas
        Route::resource('marcas', MarcaController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // Tipos
        Route::resource('tipos', TipoController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // Anios
        Route::resource('anios', AnioController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // Vehiculos
        Route::resource('vehiculos', VehiculoController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // Caracteristicas de Vehiculos
        Route::resource('caracteristica_vehiculos', CaracteristicaVehiculoController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // Faqs
        Route::resource('faqs', FaqController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // historial acciones
        Route::resource('historial_accions', HistorialAccionController::class)->only([
            'index', 'show'
        ]);

        // REPORTES
        Route::post('reportes/usuarios', [ReporteController::class, 'usuarios']);
    });
});


// ---------------------------------------
Route::get('/administracion/{optional?}', function () {
    return view('app');
})->name('base_path')->where('optional', '.*');
