<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('datosproyecto/{id}', [App\Http\Controllers\ObjetoController::class, 'obtenerDatos']);
Route::get('datoscapa/{id}', [App\Http\Controllers\CapaController::class, 'obtenerDatosCapa']);
Route::get('obtenercapas', [App\Http\Controllers\CapaController::class, 'obtenercapas']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');

    //Alertas
    Route::resource('alertas', App\Http\Controllers\AlertaController::class);
    Route::patch('alertas/{alerta}/toggle', [App\Http\Controllers\AlertaController::class, 'toggleActiva'])->name('alertas.toggle');
    Route::post('alertas/{alerta}/marcar-leida', [App\Http\Controllers\AlertaController::class, 'marcarLeida'])->name('alertas.marcar-leida');

    //Capas y objetos
    //Route::get('mapa/{id}', [App\Http\Controllers\CapaController::class, 'mostrarmapa'])->name('mostrar.mapa');
    Route::get('/capas/{id}/exportar', [App\Http\Controllers\CapaController::class, 'exportarGeoJSON'])->name('capas.exportar');
    Route::get('/aplicaciones/mapa_interno', [App\Http\Controllers\HomeController::class, 'mapa_interno'])->name('aplicaciones.mapa_interno');
    Route::get('/aplicaciones/importar', [App\Http\Controllers\CapaController::class, 'importar'])->name('aplicaciones.importar');
    Route::post('/capas/{id}/importar-geojson', [App\Http\Controllers\CapaController::class, 'importarGeojson'])->name('capas.importar');

    Route::get('objetos/importar/{capaId}', [App\Http\Controllers\ObjetoController::class, 'mostrarImportar'])->name('objetos.importar.form');
    Route::post('objetos/importar', [App\Http\Controllers\ObjetoController::class, 'importarExcel'])->name('objetos.importar');


    Route::resource('capas', App\Http\Controllers\CapaController::class);
    Route::resource('capas.objetos', App\Http\Controllers\ObjetoController::class)->shallow();

    // Ruta del mapa con nombre de capa
    Route::get('/mapa/{slug}', [App\Http\Controllers\MapaController::class, 'mostrar'])->name('mapa.mostrar'); // esto esta pendiente de mejora con respecto al otro metodo parecido

    //Profile
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('profile/{userId}', [App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store');
    Route::patch('profile/{userId}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/{userId}/download-avatar', [App\Http\Controllers\ProfileController::class, 'downloadAvatar'])->name('profile.download-avatar');

    //Descuentos
    Route::resource('descuentos', App\Http\Controllers\DescuentoController::class);
    Route::post('descuentos/generar-codigos', [App\Http\Controllers\DescuentoController::class, 'generarCodigos'])->name('descuentos.generar');
    Route::patch('descuentos/{descuento}/toggle', [App\Http\Controllers\DescuentoController::class, 'toggleActivo'])->name('descuentos.toggle');

    //Noticias
    Route::resource('noticias', App\Http\Controllers\NoticiaController::class);
    // Ruta pública
    Route::get('noticias-publico', [App\Http\Controllers\NoticiaController::class, 'publicIndex'])->name('noticias.publico');

    //Paseos
    Route::resource('paseos', App\Http\Controllers\PaseoController::class);

    //Ponencias
    Route::resource('ponencias', App\Http\Controllers\PonenciaController::class);
    Route::post('ponencias/importar', [App\Http\Controllers\PonenciaController::class, 'importarExcel'])->name('ponencias.importar');
    Route::patch('ponencias/{ponencia}/toggle-aprobada', [App\Http\Controllers\PonenciaController::class, 'toggleAprobada'])->name('ponencias.toggle');
    Route::get('mi-ponencia', [App\Http\Controllers\PonenciaController::class, 'miPonencia'])->name('ponencias.mi-ponencia');
    Route::patch('ponencias/{ponencia}/subir-archivo', [App\Http\Controllers\PonenciaController::class, 'subirArchivo'])->name('ponencias.subir-archivo');

    //Reportes
    Route::resource('reportes', App\Http\Controllers\ReporteController::class);

    //Roles
    Route::resource('roles', App\Http\Controllers\RoleController::class);


    Route::get('/historial-emails', [App\Http\Controllers\EmailHistoryController::class, 'index'])
        ->name('email-history.index');

    Route::get('/historial-emails/{id}', [App\Http\Controllers\EmailHistoryController::class, 'show'])
        ->name('email-history.show');

    Route::delete('/historial-emails/{id}', [App\Http\Controllers\EmailHistoryController::class, 'destroy'])
        ->name('email-history.destroy');

    Route::post('test_email', [App\Http\Controllers\HomeController::class, 'testMail']);


    //Templates
    Route::get('/correos/historial', [App\Http\Controllers\TemplateController::class, 'historial_show'])->name('correos.historial');
    Route::resource('templates', App\Http\Controllers\TemplateController::class);

    //Users
    Route::resource('users', App\Http\Controllers\UserController::class);
});
