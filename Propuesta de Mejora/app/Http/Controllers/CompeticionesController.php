<?php

namespace App\Http\Controllers;

use App\Models\competicion;
use App\Models\paises;
use Illuminate\Http\Request;

class CompeticionesController extends Controller
{
    private function seleccion(int $id)
    {
        return competicion::with(['pais', 'clubes', 'estadisticas'])->findOrFail($id);
    }

    public function listar()
    {
        $competiciones = competicion::with(['pais'])->orderBy('Nombre', 'asc')->paginate(15);

        return view('contenido.competiciones.listar', compact('competiciones'));
    }

    public function ver(int $id)
    {
        $competicion = $this->seleccion($id);

        return view('contenido.competiciones.ver', compact('competicion'));
    }

    public function editar(int $id)
    {
        $competicion = $this->seleccion($id);
        $paises = paises::orderBy('Nombre', 'asc')->get();

        return view('contenido.competiciones.editar', compact('competicion', 'paises'));
    }

    public function creacion()
    {
        $paises = paises::orderBy('Nombre', 'asc')->get();

        return view('contenido.competiciones.nuevo', compact('paises'));
    }

    public function actualizar(int $id, Request $request)
    {
        $tiposValidos = ['Liga', 'Copa Nacional', 'Copa de la Liga', 'Supercopa', 'Copa Continental', 'Copa Intercontinental', 'Torneo Amistoso'];

        $request->validate([
            'Nombre' => 'required|string|max:50',
            'Pais'   => 'nullable|integer|exists:paises,ID_Pais',
            'Tipo'   => 'required|in:' . implode(',', $tiposValidos),
        ]);

        $competicion = $this->seleccion($id);
        $competicion->Nombre = htmlspecialchars($request->input('Nombre'));
        $competicion->Pais   = $request->input('Pais') ?: null;
        $competicion->Tipo   = $request->input('Tipo');
        $competicion->save();

        return redirect()->route('competiciones.principal')->with('success', 'Competición "' . $competicion->Nombre . '" actualizada con éxito');
    }

    public function crear(Request $request)
    {
        $tiposValidos = ['Liga', 'Copa Nacional', 'Copa de la Liga', 'Supercopa', 'Copa Continental', 'Copa Intercontinental', 'Torneo Amistoso'];

        $request->validate([
            'Nombre' => 'required|string|max:50',
            'Pais'   => 'nullable|integer|exists:paises,ID_Pais',
            'Tipo'   => 'required|in:' . implode(',', $tiposValidos),
        ]);

        $competicion = new competicion();
        $competicion->Nombre = htmlspecialchars($request->input('Nombre'));
        $competicion->Pais   = $request->input('Pais') ?: null;
        $competicion->Tipo   = $request->input('Tipo');
        $competicion->save();

        return redirect()->route('competiciones.principal')->with('success', 'Competición "' . $competicion->Nombre . '" creada con éxito');
    }

    public function eliminar(int $id)
    {
        $competicion = $this->seleccion($id);
        $nombre = $competicion->Nombre;
        competicion::destroy($id);

        return redirect()->route('competiciones.principal')->with('success', 'Competición "' . $nombre . '" borrada con éxito.');
    }
}
