@extends('components.layouts.config_layout')
@section('title', 'Editar Usuario')

@php
    $tipos_usuario = [
        'admin','club','agente','ojeador','jugador'
    ];
@endphp

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded ">
    <h2 class="h4 mb-4 text-dark">Editar Usuario de {{ $usuario->name }}</h2>
    
    <form action="{{ route('usuarios.actualizar', ['id' => $usuario->id]) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3">
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $usuario->name) }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Email</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Tipo de Usuario</label>
                <select name="tipo_usuario" class="form-select">
                    @foreach($tipos_usuario as $opcion)
                        <option value="{{ $opcion }}" {{ $usuario->tipo_usuario == $opcion ? 'selected' : '' }}>
                            {{ $opcion }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="password form-label fw-bold small text-secondary">Nueva Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4 ">
                Actualizar Datos
            </button>
            <a href="{{ route('usuarios.ver', ['id' => $usuario->id]) }}" class="btn btn-secondary px-4">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </form>
</div>

<style>
    body {
        background-color: #f4f7f6;
        font-family: 'Open Sans', sans-serif;
    }
    .form-control, .form-select, .input-group-text {
        height: 42px;
    }
    .nav-link { color: #cbd5e1; }
</style>
@endsection
