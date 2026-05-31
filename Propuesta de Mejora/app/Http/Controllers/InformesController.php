<?php

namespace App\Http\Controllers;

use App\Models\informes_scouting as informes;
use App\Models\jugadores;
use App\Models\ojeadores;
use App\Models\partidos;
use Illuminate\Http\Request;

class InformesController extends Controller
{
    private function seleccion(int $id)
    {
        return informes::with(['jugador.club', 'jugador.pais', 'jugador.agente', 'jugador.usuario','ojeador.pais', 'ojeador.usuario','partido.Local', 'partido.Visitante', 'partido.pais'])->findOrFail($id);
    }

    public function listar()
    {
        $ojeadores = ojeadores::with(['pais'])->get();
        $informes = informes::with(['jugador.club', 'jugador.pais', 'jugador.agente','partido.Local', 'partido.Visitante', 'partido.pais'])->OrderBy('Fecha_Informe','desc')->paginate(15);
    
        return view('contenido.informes.listar', compact('informes','ojeadores'));
    }

    public function ver(int $id)
    {
        $informe = $this->seleccion($id);
        
        return view('contenido.informes.ver', compact('informe'));
    }
    
    public function editar(int $id)
    {
        $informe = informes::findOrFail($id);
        $jugadores = jugadores::get();
        $ojeadores = ojeadores::get();
        $ojeadorActual = $ojeadores->firstWhere('ID_Ojeador', auth()->id());
        $partidos = partidos::get();

        return view('contenido.informes.editar', compact('informe', 'jugadores', 'ojeadores', 'partidos'));
    }
    
    public function creacion()
    {        
        $jugadores = jugadores::get();
        $ojeadores = ojeadores::get();
        $ojeadorActual = $ojeadores->firstWhere('ID_Ojeador', auth()->id());
        $partidos  = partidos::get();

        return view('contenido.informes.nuevo', compact('jugadores', 'ojeadores', 'partidos'));
    }

    public function actualizar(int $id, Request $request)
    {
        $request->validate([
            'ID_Jugador'    => 'required|integer|exists:jugadores,ID_Jugador',
            'ID_Ojeador'    => 'required|integer|exists:ojeadores,ID_Ojeador',
            'ID_Partido'    => 'required|integer|exists:partidos_cubiertos,ID_Partido_Cubierto',
            'Fecha_Informe' => 'required|date',
            'Potencial'     => 'required|integer|between:1,100',
            'Valoraciones'  => 'required|string'
        ]);

        $informe = informes::findOrFail($id);

        $informe->Jugador = $request->input('ID_Jugador');
        $informe->Ojeador = $request->input('ID_Ojeador');
        $informe->Partido_Cubierto = $request->input('ID_Partido');
        $informe->Fecha_Informe = $request->input('Fecha_Informe');
        $informe->Potencial = $request->input('Potencial');
        $informe->Valoraciones = $request->input('Valoraciones');

        $informe->save();

        return redirect()->route('informes.principal')->with('success', 'Informe actualizado con éxito.');
    }

    public function crear(Request $request)
    {
        $request->validate([
            'ID_Jugador'    => 'required|integer|exists:jugadores,ID_Jugador',
            'ID_Ojeador'    => 'required|integer|exists:ojeadores,ID_Ojeador',
            'ID_Partido'    => 'required|integer|exists:partidos_cubiertos,ID_Partido_Cubierto',
            'Fecha_Informe' => 'required|date',
            'Potencial'     => 'required|integer|between:1,100',
            'Valoraciones'  => 'required|string'
        ]);

        $informe = new informes();

        $informe->Jugador          = $request->input('ID_Jugador');
        $informe->Ojeador          = $request->input('ID_Ojeador');
        $informe->Partido_Cubierto = $request->input('ID_Partido');
        $informe->Fecha_Informe    = $request->input('Fecha_Informe');
        $informe->Potencial        = $request->input('Potencial');
        $informe->Valoraciones     = $request->input('Valoraciones');

        $informe->save();

        return redirect()->route('informes.principal')->with('success', 'Informe creado con éxito.');
    }

    public function eliminar(int $id) 
    {
        informes::destroy($id);

        return redirect()->route('informes.principal')->with('success', 'Informe eliminado con éxito.');
    }

}