<?php

namespace App\Http\Controllers;

use App\Models\clubes;
use App\Models\paises;
use App\Models\partidos;
use Illuminate\Http\Request;

class PartidosController extends Controller
{
    
    public function todos() {
    
        $partidos = partidos::with(['Local', 'Visitante'])->OrderBy('Fecha', 'asc')->paginate(15);

        return view('contenido.partidos.listar', compact('partidos'));
    }

    
    public function ver($id) {
        
        $partido = partidos::with(['pais', 'Local', 'Visitante'])->findOrFail($id);

        return view('contenido.partidos.ver', compact('partido'));
    }

    public function editar($id) {

        $partido = partidos::with(['pais', 'Local', 'Visitante'])->findOrFail($id);
        $clubes  = clubes::with(['pais'])->orderBy('Nombre', 'asc')->get();
        $paises  = paises::orderBy('Nombre', 'asc')->get();
        
        return view('contenido.partidos.editar', compact('partido', 'clubes', 'paises'));
    }

    public function creacion() {

        $clubes = clubes::with(['pais'])->orderBy('Nombre', 'asc')->get();
        $paises = paises::orderBy('Nombre', 'asc')->get();

        return view('contenido.partidos.nuevo', compact('clubes', 'paises'));
    }
        
    public function actualizar($id, Request $request) {
            
        $request->validate([
            'Local'           => 'required|integer|exists:clubes,ID_Club',
            'Visitante'       => 'required|integer|exists:clubes,ID_Club|different:Local',
            'Goles_Local'     => 'required|integer|min:0',
            'Goles_Visitante' => 'required|integer|min:0',
            'Pais'            => 'required|integer|exists:paises,ID_Pais',
            'Localidad'       => 'nullable|string|max:100',
            'Fecha'           => 'required|date'
        ], [
            'Visitante.different' => 'El equipo visitante no puede ser el mismo que el local.'
        ]);

        $partido = partidos::findOrFail($id);
        
        $partido->Equipo_Local = $request->input('Local');
        $partido->Equipo_Visitante = $request->input('Visitante');
        $partido->Goles_Local = $request->input('Goles_Local');
        $partido->Goles_Visitante = $request->input('Goles_Visitante');
        $partido->Pais = $request->input('Pais');
        $partido->Localidad = $request->input('Localidad');
        $partido->Fecha = $request->input('Fecha');

        if ($partido->Goles_Local > $partido->Goles_Visitante) {
            $partido->Ganador = 'Local';
        } elseif ($partido->Goles_Local < $partido->Goles_Visitante) {
            $partido->Ganador = 'Visitante';
        } else {
            $partido->Ganador = 'Empate';
        }
            
        $partido->save();
            
        return redirect()->route('partidos.ver', ['id' => $id])->with('success', 'Partido actualizado con éxito.');
    }
    
    public function nuevo(Request $formulario) {
        
        $formulario->validate([
            'Local'           => 'required|integer|exists:clubes,ID_Club',
            'Visitante'       => 'required|integer|exists:clubes,ID_Club|different:Local',
            'Goles_Local'     => 'required|integer|min:0',
            'Goles_Visitante' => 'required|integer|min:0',
            'Pais'            => 'required|integer|exists:paises,ID_Pais',
            'Localidad'       => 'nullable|string|max:100',
            'Fecha'           => 'required|date'
        ], [
            'Visitante.different' => 'El equipo visitante no puede ser el mismo que el local.'
        ]);

        $partido = new partidos();
        $partido->Equipo_Local = $formulario->input('Local');
        $partido->Equipo_Visitante = $formulario->input('Visitante');
        $partido->Goles_Local = $formulario->input('Goles_Local');
        $partido->Goles_Visitante = $formulario->input('Goles_Visitante');
        $partido->Pais = $formulario->input('Pais');
        $partido->Fecha = $formulario->input('Fecha');
        $partido->Localidad = $formulario->input('Localidad');

        if ($partido->Goles_Local > $partido->Goles_Visitante) {
            $partido->Ganador = 'Local';
        } elseif ($partido->Goles_Local < $partido->Goles_Visitante) {
            $partido->Ganador = 'Visitante';
        } else {
            $partido->Ganador = 'Empate';
        }
        
        $partido->save();

        return redirect()->route('partidos.principal')->with('success', 'Partido creado correctamente.');
    }

    public function eliminar($id) {

        partidos::destroy($id);

        return redirect()->route('partidos.principal')->with('success', 'Partido eliminado correctamente.');
    }
    
    public function vista_eliminar() {
    
        $partidos = partidos::with(['Local', 'Visitante'])->OrderBy('Fecha', 'asc')->paginate(15);

        return view('contenido.partidos.eliminar', compact('partidos'));
    }
    
}
