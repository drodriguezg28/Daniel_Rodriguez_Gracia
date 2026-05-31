<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Capturamos el valor de 'seccion' de la URL
        $seccion = $request->query('seccion', 'inicio');

        return view('admin', compact('seccion'));
    }
}
