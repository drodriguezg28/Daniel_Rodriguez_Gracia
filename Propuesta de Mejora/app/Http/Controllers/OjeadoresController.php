<?php

namespace App\Http\Controllers;

use App\Models\ojeadores;
use App\Models\paises;
use App\Models\User;
use Illuminate\Http\Request;

class OjeadoresController extends Controller
{
    private function seleccion(int $id)
    {
        return Ojeadores::with(['pais'])->findOrFail($id);
    }

    public function listar()
    {
        $ojeadores = ojeadores::with(['pais'])->OrderBy('Nombre','asc')->paginate(15);
    
        return view('contenido.ojeadores.listar', compact('ojeadores'));
    }

    public function ver(int $id)
    {
        $ojeador = $this->seleccion($id);
        
        return view('contenido.ojeadores.ver', compact('ojeador'));
    }
    
    public function editar(int $id)
    {
        $ojeador = $this->seleccion($id);
        $paises = paises::orderBy('Nombre', 'asc')->get();
        $usuarios = User::orderBy('name', 'asc')->where('tipo_usuario', 'ojeador')->get();

        return view('contenido.ojeadores.editar', compact('ojeador', 'paises', 'usuarios'));
    }
    
    public function creacion()
    {        
        $paises = paises::orderBy('Nombre', 'asc')->get();
        $usuarios = User::orderBy('name', 'asc')->where('tipo_usuario', 'ojeador')->get();

        return view('contenido.ojeadores.nuevo', compact('paises', 'usuarios'));
    }

    public function actualizar(int $id, Request $request)
    {

        // Si el usuario pulsó el botón "Probar URL"
        if ($request->input('cosa') === 'vista_previa') {
            return back()->withInput();
        }

        $request->validate([
            'Nombre'    => 'required|string|max:30',
            'Apellido1' => 'required|string|max:30',
            'Apellido2' => 'nullable|string|max:30',
            'Apodo'     => 'nullable|string|max:30',
            'Pais'      => 'required|integer|exists:paises,ID_Pais'
        ]);

        $ojeador = $this->seleccion($id);

        // 2. Actualiza los datos
        $ojeador->Nombre = $request->input('Nombre');
        $ojeador->Apellido1 = $request->input('Apellido1');
        $ojeador->Apellido2 = $request->input('Apellido2');
        $ojeador->Apodo = $request->input('Apodo');
        $ojeador->Nacionalidad = $request->input('Pais');

        $ojeador->save();

        $completo = trim($ojeador->Nombre . " " . $ojeador->Apellido1 . " " . $ojeador->Apellido2);

        return redirect()->route('ojeadores.principal')->with('success', 'ojeador ' . $completo . ' actualizado con éxito');
    }

    public function crear(Request $request)
    {

        // Si el usuario pulsó el botón "Probar URL"
        if ($request->input('cosa') === 'vista_previa') {
            return back()->withInput();
        }


        $request->validate([
            'Nombre'    => 'required|string|max:30',
            'Apellido1' => 'required|string|max:30',
            'Apellido2' => 'nullable|string|max:30',
            'Apodo'     => 'nullable|string|max:30',
            'Pais'      => 'required|integer|exists:paises,ID_Pais'
        ]);

        $ojeador = new Ojeadores();
        $ojeador->Nombre = $request->input('Nombre');
        $ojeador->Apellido1 = $request->input('Apellido1');
        $ojeador->Apellido2 = $request->input('Apellido2');
        $ojeador->Apodo = $request->input('Apodo');
        $ojeador->Nacionalidad = $request->input('Pais');

        $ojeador->save();

        $completo = trim($ojeador->Nombre . " " . $ojeador->Apellido1 . " " . $ojeador->Apellido2);

        return redirect()->route('ojeadores.principal')->with('success', 'ojeador ' . $completo . ' creado con éxito');
    }

    public function eliminar (int $id) 
    {
        $ojeador = $this->seleccion($id);
        $completo = trim($ojeador->Nombre . " " . $ojeador->Apellido1 . " " . $ojeador->Apellido2);

        Ojeadores::destroy($id);

        return redirect()->route('ojeadores.principal')->with('success', 'ojeador ' . $completo  . ' borrado con éxito.');
    }

}
