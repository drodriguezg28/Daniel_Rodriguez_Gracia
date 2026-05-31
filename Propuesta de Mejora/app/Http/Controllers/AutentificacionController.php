<?php

namespace App\Http\Controllers;

use App\Models\agentes;
use App\Models\clubes;
use App\Models\competicion;
use App\Models\informes_scouting;
use App\Models\jugadores;
use App\Models\ojeadores;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AutentificacionController extends Controller
{
    public function verificar() {

        $pag = "contenido.paginas_principales";
        $user = Auth::user();

        if ($user->tipo_usuario === 'admin') {
            $totalinformes     = informes_scouting::count();
            $totaljugadores    = jugadores::count();
            $totalojeadores    = ojeadores::count();
            $totalagentes      = agentes::count();
            $totalclubes       = clubes::count();
            $totalcompeticiones= competicion::count();
            $totalusuarios     = User::count();
            $ultimosinformes   = informes_scouting::with(['partido.Local','partido.Visitante','ojeador'])->latest()->take(5)->get();
            
            return view('contenido.principal_admin', compact(
                'totalinformes','totaljugadores','totalojeadores',
                'totalagentes','totalclubes','totalcompeticiones',
                'totalusuarios','ultimosinformes'
            ));
        }
        elseif ($user->tipo_usuario === 'ojeador') {

            $ojeador = ojeadores::with(['usuario'])->where('Usuario',$user->id)->first();

            if (!$ojeador) {
                return response()->view('errors.403', ['exception' => new \Exception("Tu perfil de ojeador aún no ha sido vinculado. Contacta con el administrador.")], 403);
            }

            $informesojeador = informes_scouting::with([
                'partido.Local','partido.Visitante',
                'jugador.club','jugador.pais',
                'ojeador'
            ])->where('Ojeador',$ojeador->ID_Ojeador)->get();

            $cuentainformes    = $informesojeador->count();
            $jugadoresUnicos   = $informesojeador->pluck('jugador')->filter()->unique('ID_Jugador')->count();
            $partidosCubiertos = $informesojeador->pluck('partido')->filter()->unique('ID_Partido_Cubierto')->count();
            $ultimoInforme     = $informesojeador->sortByDesc('created_at')->first();

            return view('contenido.ojeadores.principal', compact(
                'ojeador','informesojeador','cuentainformes',
                'jugadoresUnicos','partidosCubiertos','ultimoInforme'
            ));
        }
        elseif ($user->tipo_usuario === 'agente') {

            $agente = agentes::with(['usuario'])->where('Usuario',$user->id)->first();
            
            if (!$agente) {
                return response()->view('errors.403', ['exception' => new \Exception("Tu perfil de agente aún no ha sido vinculado. Contacta con el administrador.")], 403);
            }

            $jugadores = jugadores::with(['club','pais','estadisticas'])->where('Agente',$agente->ID_Agente)->get();

            $cuentajugadores  = $jugadores->count();
            $totalGoles       = $jugadores->sum(fn($j) => $j->estadisticas->sum('Goles'));
            $totalAsistencias = $jugadores->sum(fn($j) => $j->estadisticas->sum('Asistencias'));
            $valorTotal       = $jugadores->sum('Valor_Mercado');

            return view('contenido.agentes.principal', compact(
                'agente','jugadores','cuentajugadores',
                'totalGoles','totalAsistencias','valorTotal'
            ));

        }
        elseif ($user->tipo_usuario === 'jugador') {

            $jugador = jugadores::with([
                'estadisticas.temporada',
                'estadisticas.competicion',
                'estadisticas.club',
                'club.pais',
                'agente',
                'pais',
            ])->where('Usuario', $user->id)->first();

            if (!$jugador) {
                return response()->view('errors.403', ['exception' => new \Exception("Tu perfil de jugador aún no ha sido vinculado. Contacta con el administrador.")], 403);
            }

            return view('contenido.jugadores.principal_jugador', compact('jugador'));
        }

        abort(403, 'No eres un usuario con permisos. Contacta con el administrador');
    }
}
