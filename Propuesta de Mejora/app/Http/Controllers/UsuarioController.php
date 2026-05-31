<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    private function seleccion(int $id)
    {
        // Adaptado para seguir el estilo de búsqueda del controlador Agentes
        return User::findOrFail($id);
    }

    public function listar()
    {
        $usuarios = User::orderBy('name', 'asc')->paginate(15);
    
        return view('contenido.usuarios.listar', compact('usuarios'));
    }

    public function ver(int $id)
    {
        $usuario = $this->seleccion($id);
        
        return view('contenido.usuarios.ver', compact('usuario'));
    }
    
    public function editar(int $id)
    {
        $usuario = $this->seleccion($id);
        
        return view('contenido.usuarios.editar', compact('usuario'));
    }
    
    public function creacion()
    {
        return view('contenido.usuarios.nuevo');
    }

    public function actualizar(int $id, Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $id,
            'tipo_usuario' => 'required|in:admin,ojeador,agente',
            'password'     => 'nullable|string|min:8'
        ]);

        $usuario = $this->seleccion($id);

        $usuario->name = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->tipo_usuario = $request->input('tipo_usuario');
        
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->input('password'));
        }
        
        $usuario->save();

        return redirect()->route('usuarios.principal')->with('success', 'Usuario ' . $usuario->name . ' actualizado con éxito');
    }

    public function crear(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'tipo_usuario' => 'required|in:admin,ojeador,agente',
            'password'     => 'required|string|min:8'
        ]);

        $usuario = new User();
        $usuario->name = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->tipo_usuario = $request->input('tipo_usuario');
        $usuario->password = Hash::make($request->input('password'));

        $usuario->save();

        return redirect()->route('usuarios.principal')->with('success', 'Usuario ' . $usuario->name . ' creado con éxito');
    }

    public function eliminar(int $id) 
    {
        $usuario = $this->seleccion($id);
        $nombre = $usuario->name;
        
        User::destroy($id);

        return redirect()->route('usuarios.principal')->with('success', 'Usuario ' . $nombre . ' borrado correctamente.');
    }
}