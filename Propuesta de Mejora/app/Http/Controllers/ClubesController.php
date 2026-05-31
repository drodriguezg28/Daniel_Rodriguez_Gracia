<?php

namespace App\Http\Controllers;

use App\Models\clubes;
use App\Models\paises;
use App\Models\User;
use Illuminate\Http\Request;

class ClubesController extends Controller
{
    private function seleccion(int $id)
    {
        return clubes::with(['pais'])->findOrFail($id);
    }

    public function listar()
    {
        $clubes = clubes::with(['pais'])->OrderBy('Nombre','asc')->paginate(15);
    
        return view('contenido.clubes.listar', compact('clubes'));
    }

    public function ver(int $id)
    {
        $club = $this->seleccion($id);
        
        return view('contenido.clubes.ver', compact('club'));
    }
    
    public function editar(int $id)
    {
        $club   = $this->seleccion($id);
        $paises = paises::orderBy('Nombre', 'asc')->get();
        $usuarios = User::orderBy('name', 'asc')->where('tipo_usuario', 'club')->get();

        return view('contenido.clubes.editar', compact('club', 'paises', 'usuarios'));
    }
    
    public function creacion()
    {        
        $paises = paises::orderBy('Nombre', 'asc')->get();
        $usuarios = User::orderBy('name', 'asc')->where('tipo_usuario', 'club')->get();

        return view('contenido.clubes.nuevo', compact('paises', 'usuarios'));
    }

    public function actualizar(int $id, Request $request)
    {

        // Si el usuario pulsó el botón "Probar URL"
        if ($request->input('cosa') === 'vista_previa') {
            return back()->withInput();
        }

        $request->validate([
            'Nombre'   => 'required|string|max:100',
            'Pais'     => 'required|integer|exists:paises,ID_Pais',
            'url_logo' => 'nullable|url'
        ]);

        $club = $this->seleccion($id);

        $club->Nombre = $request->input('Nombre');
        $club->Pais = $request->input('Pais');
        $club->url_logo = $request->input('url_logo');
        
        $club->save();

        return redirect()->route('clubes.principal')->with('success', 'Club ' . $club->Nombre . ' actualizado con éxito');
    }

    public function crear(Request $request)
    {

        // Si el usuario pulsó el botón "Probar URL"
        if ($request->input('cosa') === 'vista_previa') {
            return back()->withInput();
        }


        $request->validate([
            'Nombre'   => 'required|string|max:100',
            'Pais'     => 'required|integer|exists:paises,ID_Pais',
            'url_logo' => 'nullable|url'
        ]);

        $club = new clubes();
        $club->Nombre = $request->input('Nombre');
        $club->Pais = $request->input('Pais');
        $club->url_logo = $request->input('url_logo');

        $club->save();

        return redirect()->route('clubes.principal')->with('success', 'Club ' . $club->Nombre . ' creado con éxito');
    }

    public function eliminar (int $id) 
    {
        $club= $this->seleccion($id);
        clubes::destroy($id);

        return redirect()->route('clubes.principal')->with('success', 'Club ' . $club->Nombre . ' borrado con éxito.');
    }

}