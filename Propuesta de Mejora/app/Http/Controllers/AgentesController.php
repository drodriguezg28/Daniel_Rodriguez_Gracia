<?php

namespace App\Http\Controllers;
use App\Models\agentes;
use App\Models\paises;
use App\Models\User;
use Illuminate\Http\Request;

class AgentesController extends Controller
{
    private function seleccion(int $id)
    {
        return agentes::with(['pais'])->findOrFail($id);
    }

    public function listar()
    {
        $agentes = agentes::with(['pais'])->OrderBy('Nombre','asc')->paginate(15);
    
        return view('contenido.agentes.listar', compact('agentes'));
    }

    public function ver(int $id)
    {
        $agente = $this->seleccion($id);
        
        return view('contenido.agentes.ver', compact('agente'));
    }
    
    public function editar(int $id)
    {
        $agente = $this->seleccion($id);
        $paises = paises::orderBy('Nombre', 'asc')->get();
        $usuarios = User::orderBy('name', 'asc')->where('tipo_usuario','agente')->get();
        return view('contenido.agentes.editar', compact('agente', 'paises', 'usuarios'));
    }
    
    public function creacion()
    {
        $paises = paises::orderBy('Nombre', 'asc')->get();
        $usuarios = User::orderBy('name', 'asc')->where('tipo_usuario','agente')->get();

        return view('contenido.agentes.nuevo', compact('paises', 'usuarios'));
    }


    public function actualizar(int $id, Request $request)
    {
        $request->validate([
            'Nombre'    => 'required|string|max:30',
            'Apellido1' => 'required|string|max:30',
            'Apellido2' => 'nullable|string|max:30',
            'Pais'      => 'required|integer|exists:paises,ID_Pais'
        ]);

        $agente = $this->seleccion($id);

        $agente->Nombre = $request->input('Nombre');
        $agente->Apellido1 = $request->input('Apellido1');
        $agente->Apellido2 = $request->input('Apellido2');
        $agente->Nacionalidad = $request->input('Pais');

        
        $agente->save();

        $completo = trim($agente->Nombre . " " . $agente->Apellido1 . " " . $agente->Apellido2);

        return redirect()->route('agentes.principal')->with('success', 'Agente ' . $completo . ' actualizado con éxito');
    }

    public function crear(Request $request)
    {
        $request->validate([
            'Nombre'    => 'required|string|max:30',
            'Apellido1' => 'required|string|max:30',
            'Apellido2' => 'nullable|string|max:30',
            'Pais'      => 'required|integer|exists:paises,ID_Pais'
        ]);

        $agente = new Agentes();
        $agente->Nombre     = $request->input('Nombre');
        $agente->Apellido1 = $request->input('Apellido1');
        $agente->Apellido2 = $request->input('Apellido2');
        $agente->Nacionalidad = $request->input('Pais');

        $agente->save();

        $completo = trim($agente->Nombre . " " . $agente->Apellido1 . " " . $agente->Apellido2);

        return redirect()->route('agentes.principal')->with('success', 'Agente ' . $completo . ' creado con éxito');

    }

    public function eliminar (int $id) 
    {
        $agente = $this->seleccion($id);
        $completo = trim($agente->Nombre . " " . $agente->Apellido1 . " " . $agente->Apellido2);
        agentes::destroy($id);

        return redirect()->route('agentes.principal')->with('success', 'Agente '. $completo . ' borrado correctamente.');
    
    }

}
