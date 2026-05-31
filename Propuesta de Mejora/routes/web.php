<?php

use App\Http\Controllers\AgentesController;
use App\Http\Controllers\AutentificacionController;
use App\Http\Controllers\ClubesController;
use App\Http\Controllers\CompeticionesController;
use App\Http\Controllers\InformesController;
use App\Http\Controllers\JugadoresController;
use App\Http\Controllers\OjeadoresController;
use App\Http\Controllers\PartidosController;
use App\Http\Controllers\UsuarioController;
use App\Models\agentes;
use App\Models\informes_scouting;
use App\Models\jugadores;
use App\Models\ojeadores;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;


Route::middleware(['auth'])->group(function () {

    
    // Pestaña de inicio por tipo de usuario
        Route::get('/', [AutentificacionController::class, 'verificar'])->name('dashboard');
        Route::view('dashboard', 'dashboard')->name('dashboard');
    

    //Jugadores
        Route::prefix('jugadores')->name('jugadores.')->group(function () {
            //Listar
            Route::get('/principal', [JugadoresController::class, 'listar'])->name('principal');
            //Ver
            Route::get('/ver/{id}', [JugadoresController::class, 'ver'])->name('ver');
            //Editar
            Route::get('/modificar/{id}', [JugadoresController::class, 'editar'])->name('editar');
            Route::put('/modificar/{id}', [JugadoresController::class, 'actualizar'])->name('actualizar');
            //Crear
            Route::get('/nuevo', [JugadoresController::class, 'creacion'])->name('creacion');
            Route::put('/nuevo', [JugadoresController::class, 'crear'])->name('crear');
            //Eliminar
            Route::delete('/eliminar/{id}', [JugadoresController::class, 'eliminar'])->name('eliminar');
        });

    // Área personal del Jugador autenticado
        Route::prefix('jugador')->name('jugador.')->group(function () {
            Route::get('/perfil', [JugadoresController::class, 'miPerfil'])->name('perfil');
            Route::put('/perfil', [JugadoresController::class, 'actualizarMiPerfil'])->name('perfil.actualizar');
        });





    // Ojeadores
        Route::prefix('ojeadores')->name('ojeadores.')->group(function () {
            //Listar
            Route::get('/principal', [OjeadoresController::class, 'listar'])->name('principal');
            //Ver
            Route::get('/ver/{id}', [OjeadoresController::class, 'ver'])->name('ver');
            //Editar
            Route::get('/modificar/{id}', [OjeadoresController::class, 'editar'])->name('editar');
            Route::put('/modificar/{id}', [OjeadoresController::class, 'actualizar'])->name('actualizar');
            //Crear
            Route::get('/nuevo', [OjeadoresController::class, 'creacion'])->name('creacion');
            Route::put('/nuevo', [OjeadoresController::class, 'crear'])->name('crear');
            //Eliminar
            Route::delete('/eliminar/{id}', [OjeadoresController::class, 'eliminar'])->name('eliminar');
        });



    // Usuarios
        Route::prefix('usuarios')->name('usuarios.')->group(function () {
            //Listar
            Route::get('/principal', [UsuarioController::class, 'listar'])->name('principal');
            //Ver
            Route::get('/ver/{id}', [UsuarioController::class, 'ver'])->name('ver');
            //Editar
            Route::get('/modificar/{id}', [UsuarioController::class, 'editar'])->name('editar');
            Route::put('/modificar/{id}', [UsuarioController::class, 'actualizar'])->name('actualizar');
            //Crear
            Route::get('/nuevo', [UsuarioController::class, 'creacion'])->name('creacion');
            Route::put('/nuevo', [UsuarioController::class, 'crear'])->name('crear');
            //Eliminar
            Route::delete('/eliminar/{id}', [UsuarioController::class, 'eliminar'])->name('eliminar');
        });


    // Agentes

        Route::prefix('agentes')->name('agentes.')->group(function () {
            //Listar
            Route::get('/principal', [AgentesController::class, 'listar'])->name('principal');
            //Ver
            Route::get('/ver/{id}', [AgentesController::class, 'ver'])->name('ver');
            //Editar
            Route::get('/modificar/{id}', [AgentesController::class, 'editar'])->name('editar');
            Route::put('/modificar/{id}', [AgentesController::class, 'actualizar'])->name('actualizar');
            //Crear
            Route::get('/nuevo', [AgentesController::class, 'creacion'])->name('creacion');
            Route::put('/nuevo', [AgentesController::class, 'crear'])->name('crear');
            //Eliminar
            Route::delete('/eliminar/{id}', [AgentesController::class, 'eliminar'])->name('eliminar');
        });
    

    // Clubes

        Route::prefix('clubes')->name('clubes.')->group(function () {
            //Listar
            Route::get('/principal', [ClubesController::class, 'listar'])->name('principal');
            //Ver
            Route::get('/ver/{id}', [ClubesController::class, 'ver'])->name('ver');
            //Editar
            Route::get('/modificar/{id}', [ClubesController::class, 'editar'])->name('editar');
            Route::put('/modificar/{id}', [ClubesController::class, 'actualizar'])->name('actualizar');
            //Crear
            Route::get('/nuevo', [ClubesController::class, 'creacion'])->name('creacion');
            Route::put('/nuevo', [ClubesController::class, 'crear'])->name('crear');
            //Eliminar
            Route::delete('/eliminar/{id}', [ClubesController::class, 'eliminar'])->name('eliminar');
        });


    // Partidos
        Route::prefix('partidos')->name('partidos.')->group(function () {
            //Listar
            Route::get('/principal', [PartidosController::class, 'todos'])->name('principal');
            //Ver
            Route::get('/ver/{id}', [PartidosController::class, 'ver'])->name('ver');
            //Editar
            Route::get('/modificar/{id}', [PartidosController::class, 'editar'])->name('editar');
            Route::put('/modificar/{id}', [PartidosController::class, 'actualizar'])->name('actualizar');
            //Crear
            Route::get('/nuevo', [PartidosController::class, 'creacion'])->name('creacion');
            Route::put('/nuevo', [PartidosController::class, 'nuevo'])->name('crear');
            //Eliminar vista
            Route::get('/eliminar', [PartidosController::class, 'vista_eliminar'])->name('vista_eliminar');
            //Eliminar
            Route::delete('/eliminar/{id}', [PartidosController::class, 'eliminar'])->name('eliminar');
        });

    
    // Informes

        Route::prefix('informes')->name('informes.')->group(function () {
            //Listar
            Route::get('/principal', [InformesController::class, 'listar'])->name('principal');
            //Ver
            Route::get('/ver/{id}', [InformesController::class, 'ver'])->name('ver');
            //Editar
            Route::get('/modificar/{id}', [InformesController::class, 'editar'])->name('editar');
            Route::put('/modificar/{id}', [InformesController::class, 'actualizar'])->name('actualizar');
            //Crear
            Route::get('/nuevo', [InformesController::class, 'creacion'])->name('creacion');
            Route::put('/nuevo', [InformesController::class, 'crear'])->name('crear');
            //Eliminar
            Route::delete('/eliminar/{id}', [InformesController::class, 'eliminar'])->name('eliminar');
        });


    // Competiciones

        Route::prefix('competiciones')->name('competiciones.')->group(function () {
            //Listar
            Route::get('/principal', [CompeticionesController::class, 'listar'])->name('principal');
            //Ver
            Route::get('/ver/{id}', [CompeticionesController::class, 'ver'])->name('ver');
            //Editar
            Route::get('/modificar/{id}', [CompeticionesController::class, 'editar'])->name('editar');
            Route::put('/modificar/{id}', [CompeticionesController::class, 'actualizar'])->name('actualizar');
            //Crear
            Route::get('/nuevo', [CompeticionesController::class, 'creacion'])->name('creacion');
            Route::put('/nuevo', [CompeticionesController::class, 'crear'])->name('crear');
            //Eliminar
            Route::delete('/eliminar/{id}', [CompeticionesController::class, 'eliminar'])->name('eliminar');
        });


});



Auth::routes(['register' => false]);