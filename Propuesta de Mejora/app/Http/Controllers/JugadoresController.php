<?php

namespace App\Http\Controllers;

use App\Models\agentes;
use App\Models\clubes;
use App\Models\jugadores;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class JugadoresController extends Controller
{
    private function seleccion(int $id)
    {
        return jugadores::with([
            'estadisticas.temporada',
            'estadisticas.competicion',
            'estadisticas.club',
            'informes.ojeador.usuario',
            'informes.partido.Local',
            'informes.partido.Visitante',
            'contratos',
            'temporadas',
            'club.pais',
            'agente',
            'pais',
            'usuario'
        ])->findOrFail($id);
    }
    public function listar()
    {
        $jugadores = jugadores::with(['estadisticas','contratos','temporadas','club','agente','pais','usuario'])->OrderBy('Apellido1','asc')->paginate(15);
        
        return view('contenido.jugadores.listar', compact('jugadores'));
    }

    public function ver(int $id)
    {
        $jugador = $this->seleccion($id);
        
        return view('contenido.jugadores.ver', compact('jugador'));
    }
    
    public function editar(int $id)
    {
        $jugador = $this->seleccion($id);
        $clubes = clubes::OrderBy('Nombre','asc')->with(['pais'])->get();
        $agentes = agentes::OrderBy('Apellido1','asc')->get();

        if ($jugador->Valor_Mercado != 0) {
            $jugador->Valor_Mercado = $jugador->Valor_Mercado / 1000000 ;
        }
        

        if ($jugador->Altura != 0) {
            $jugador->Altura = $jugador->Altura * 100;
        }
        
        $usuarios = User::orderBy('name', 'asc')->get();

        return view('contenido.jugadores.editar', compact('jugador','clubes','agentes','usuarios'));
    }
    
    public function creacion()
    {
        $clubes = clubes::OrderBy('Nombre','asc')->with(['pais'])->get();
        $agentes = agentes::OrderBy('Apellido1','asc')->get();

        $usuarios = User::orderBy('name', 'asc')->get();

        return view('contenido.jugadores.nuevo', compact('clubes','agentes','usuarios'));
    }


    public function actualizar(int $id, Request $request)
    {
        
        // Si el usuario pulsó el botón "Probar URL"
        if ($request->input('cosa') === 'vista_previa') {
            return back()->withInput();
        }

        $request->validate([
            'Nombre'              => 'required|string|max:30',
            'Apellido1'           => 'required|string|max:30',
            'Apellido2'           => 'nullable|string|max:30',
            'Apodo'               => 'nullable|string|max:30',
            'Fecha_Nacimiento'    => 'required|date',
            'Nacionalidad'        => 'nullable|integer|exists:paises,ID_Pais',
            'Altura'              => 'nullable|numeric|between:0,250',
            'Peso'                => 'nullable|numeric|between:0,200.00',
            'Posicion_Principal'  => 'required|in:Portero,Defensa Central,Lateral Derecho,Lateral Izquierdo,Carrilero,Pivote,Mediocentro,Mediapunta,Interior Derecho,Interior Izquierdo,Extremo Derecho,Extremo Izquierdo,Segundo Delantero,Delantero Centro',
            'Posicion_Secundaria' => 'nullable|in:Ninguna,Portero,Defensa Central,Lateral Derecho,Lateral Izquierdo,Carrilero,Pivote,Mediocentro,Mediapunta,Interior Derecho,Interior Izquierdo,Extremo Derecho,Extremo Izquierdo,Segundo Delantero,Delantero Centro',
            'Dorsal'              => 'nullable|integer|between:1,99',
            'Club'                => 'required|integer|exists:clubes,ID_Club',
            'Agente'              => 'nullable|integer|exists:agentes,ID_Agente',
            'Valor'               => 'nullable|string',
            'Foto_Perfil'         => 'nullable|string|max:255',
        ]);

        $jugador = $this->seleccion($id);

        if ($request->input('Valor')) {
            $valorlimpio = str_replace('.', '', htmlspecialchars($request->input('Valor')));
            $valorformateado = $valorlimpio * 1000000 ;
            $jugador->Valor_Mercado = $valorformateado;
        }
        else{
            $jugador->Valor_Mercado = 0;
        }

        if ($request->input('Altura')) {
            $alturaformateada = $request->input('Altura') / 100;
            $jugador->Altura = htmlspecialchars($alturaformateada);
        }
        else{
            $jugador->Altura = 0;
        }
    
        $jugador->Nombre = htmlspecialchars($request->input('Nombre'));
        $jugador->Apellido1 = htmlspecialchars($request->input('Apellido1'));
        $jugador->Apellido2 = htmlspecialchars($request->input('Apellido2'));
        $jugador->Apodo = htmlspecialchars($request->input('Apodo'));
        $jugador->Fecha_Nacimiento = htmlspecialchars($request->input('Fecha_Nacimiento'));
        $jugador->Nacionalidad = htmlspecialchars($request->input('Nacionalidad'));
        $jugador->Peso = htmlspecialchars($request->input('Peso'));
        $jugador->Posicion_principal = htmlspecialchars($request->input('Posicion_Principal'));
        $jugador->Posicion_secundaria = htmlspecialchars($request->input('Posicion_Secundaria'));
        $jugador->Dorsal_actual = htmlspecialchars($request->input('Dorsal'));
        $jugador->Club_Actual = htmlspecialchars($request->input('Club'));
        $jugador->Agente = htmlspecialchars($request->input('Agente'));
        $jugador->Foto_Perfil = htmlspecialchars($request->input('Foto_Perfil'));
        
        $jugador->save();

        $completo = trim($jugador->Nombre . " ". $jugador->Apellido1 . " " . $jugador->Apellido2);

        return redirect()->route('jugadores.principal')->with('success', 'jugador ' . $completo . ' actualizado con éxito');
    }

    public function crear(Request $request)
    {
        
        // Si el usuario pulsó el botón "Probar URL"
        if ($request->input('cosa') === 'vista_previa') {
            return back()->withInput();
        }

        $request->validate([
            'Nombre'              => 'required|string|max:30',
            'Apellido1'           => 'required|string|max:30',
            'Apellido2'           => 'nullable|string|max:30',
            'Apodo'               => 'nullable|string|max:30',
            'Fecha_Nacimiento'    => 'required|date',
            'Nacionalidad'        => 'nullable|integer|exists:paises,ID_Pais',
            'Altura'              => 'nullable|numeric|between:0,250',
            'Peso'                => 'nullable|numeric|between:0,200.00',
            'Posicion_Principal'  => 'required|in:Portero,Defensa Central,Lateral Derecho,Lateral Izquierdo,Carrilero,Pivote,Mediocentro,Mediapunta,Interior Derecho,Interior Izquierdo,Extremo Derecho,Extremo Izquierdo,Segundo Delantero,Delantero Centro',
            'Posicion_Secundaria' => 'nullable|in:Ninguna,Portero,Defensa Central,Lateral Derecho,Lateral Izquierdo,Carrilero,Pivote,Mediocentro,Mediapunta,Interior Derecho,Interior Izquierdo,Extremo Derecho,Extremo Izquierdo,Segundo Delantero,Delantero Centro',
            'Dorsal'              => 'nullable|integer|between:1,99',
            'Club'                => 'required|integer|exists:clubes,ID_Club',
            'Agente'              => 'nullable|integer|exists:agentes,ID_Agente',
            'Valor'               => 'nullable|string',
            'Foto_Perfil'         => 'nullable|string|max:255',
        ]);


        $jugador = new jugadores();
        
        if ($request->input('Valor')) {
            $valorlimpio = str_replace('.', '', htmlspecialchars($request->input('Valor')));
            $valorformateado = $valorlimpio * 1000000 ;
            $jugador->Valor_Mercado = $valorformateado;
        }
        else{
            $jugador->Valor_Mercado = 0;
        }

        if ($request->input('Altura')) {

            $alturaformateada = $request->input('Altura') / 100;
            $jugador->Altura = htmlspecialchars($alturaformateada);

        }
        else{
            $jugador->Altura = 0;
        }
    
        $jugador->Nombre = htmlspecialchars($request->input('Nombre'));
        $jugador->Apellido1 = htmlspecialchars($request->input('Apellido1'));
        $jugador->Apellido2 = htmlspecialchars($request->input('Apellido2'));
        $jugador->Apodo = htmlspecialchars($request->input('Apodo'));
        $jugador->Fecha_Nacimiento = htmlspecialchars($request->input('Fecha_Nacimiento'));
        $jugador->Nacionalidad = htmlspecialchars($request->input('Nacionalidad'));
        $jugador->Peso = htmlspecialchars($request->input('Peso'));
        $jugador->Posicion_principal = htmlspecialchars($request->input('Posicion_Principal'));
        $jugador->Posicion_secundaria = htmlspecialchars($request->input('Posicion_Secundaria'));
        $jugador->Dorsal_actual = htmlspecialchars($request->input('Dorsal'));
        $jugador->Club_Actual = htmlspecialchars($request->input('Club'));
        $jugador->Agente = htmlspecialchars($request->input('Agente'));
        $jugador->Foto_Perfil = htmlspecialchars($request->input('Foto_Perfil'));

        $jugador->save();

        $completo = trim($jugador->Nombre . " " . $jugador->Apellido1 . " " . $jugador->Apellido2);

        return redirect()->route('jugadores.principal')->with('success', 'jugador ' . $completo . ' creado con éxito');

    }

    public function eliminar (int $id) 
    {
        $jugador = $this->seleccion($id);
        $completo = trim($jugador->Nombre . " " . $jugador->Apellido1 . " " . $jugador->Apellido2);
        jugadores::destroy($id);

        return redirect()->route('jugadores.principal')->with('success', 'jugador '. $completo . ' borrado correctamente.');
    
    }

    // ======= Área del Jugador autenticado =======

    public function miPerfil()
    {
        $user = Auth::user();
        $jugador = jugadores::with([
            'estadisticas.temporada',
            'estadisticas.competicion',
            'estadisticas.club',
            'club.pais',
            'agente',
            'pais',
        ])->where('Usuario', $user->id)->firstOrFail();

        return view('contenido.jugadores.mi_perfil', compact('jugador'));
    }

    public function actualizarMiPerfil(Request $request)
    {
        $user = Auth::user();
        $jugador = jugadores::where('Usuario', $user->id)->firstOrFail();

        $request->validate([
            'Nombre'    => 'required|string|max:30',
            'Apellido1' => 'required|string|max:30',
            'Apellido2' => 'nullable|string|max:30',
            'Apodo'     => 'nullable|string|max:30',
            'Altura'    => 'nullable|numeric|between:0,250',
            'Peso'      => 'nullable|numeric|between:0,200',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        // Actualizar datos del jugador
        $jugador->Nombre    = htmlspecialchars($request->input('Nombre'));
        $jugador->Apellido1 = htmlspecialchars($request->input('Apellido1'));
        $jugador->Apellido2 = htmlspecialchars($request->input('Apellido2'));
        $jugador->Apodo     = htmlspecialchars($request->input('Apodo'));

        if ($request->input('Altura')) {
            $jugador->Altura = $request->input('Altura') / 100;
        } else {
            $jugador->Altura = 0;
        }

        $jugador->Peso = $request->input('Peso') ?? 0;
        $jugador->save();

        // Actualizar datos del usuario
        $user->name  = htmlspecialchars($request->input('Nombre') . ' ' . $request->input('Apellido1'));
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return redirect()->route('jugador.perfil')->with('success', 'Perfil actualizado correctamente.');
    }

}
