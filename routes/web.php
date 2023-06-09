<?php

use App\Http\Controllers\AnioController;
use App\Http\Controllers\CaracteristicaVehiculoController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HistorialAccionController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VisitanteController;
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

// LISTADOS SIN LOGEAR
Route::get("marcas/getMarcas", [MarcaController::class, "getMarcas"]);
Route::get("modelos/getModelos", [ModeloController::class, "getModelos"]);
Route::get("tipos/getTipos", [TipoController::class, "getTipos"]);
Route::get("anios/getAnios", [AnioController::class, "getAnios"]);
Route::get("faqs/getFaqs", [FaqController::class, "getFaqs"]);
Route::post("faqs/incrementaVistas/{faq}", [FaqController::class, "incrementaVistas"]);

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::post('/configuracion/update', [ConfiguracionController::class, 'update']);

        // Usuarios
        Route::post('usuarios/reemplaza_password/{usuario}', [UserController::class, 'reemplaza_password']);
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

        // Visitantes
        Route::post("visitantes/habilitarVisitante/{visitante}", [VisitanteController::class, "habilitarVisitante"]);
        Route::resource('visitantes', VisitanteController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // Chats
        Route::post("chats/actualizaEstadoChats", [ChatController::class, "actualizaEstadoChats"])->name("actualizaEstadoChats");
        Route::get("chats/getInfoChat", [ChatController::class, "getInfoChat"]);
        Route::get("chats/verifica_estado_chat/{chat}", [ChatController::class, "verifica_estado_chat"]);
        Route::get("chats/getNuevosMensajes", [ChatController::class, "getNuevosMensajes"]);
        Route::get("chats/getChatVisitante", [ChatController::class, "getChatVisitante"]);
        Route::resource('chats', ChatController::class)->only([
            'index', 'store', 'update', 'destroy', 'show'
        ]);

        // historial acciones
        Route::resource('historial_accions', HistorialAccionController::class)->only([
            'index', 'show'
        ]);

        // REPORTES
        Route::post('reportes/usuarios', [ReporteController::class, 'usuarios']);
        Route::post('reportes/vehiculos', [ReporteController::class, 'vehiculos']);
        Route::post('reportes/visitantes', [ReporteController::class, 'visitantes']);
        Route::post('reportes/vistas', [ReporteController::class, 'vistas']);
    });
});


// ---------------------------------------
Route::get('/administracion/{optional?}', function () {
    return view('app');
})->name('base_path')->where('optional', '.*');
