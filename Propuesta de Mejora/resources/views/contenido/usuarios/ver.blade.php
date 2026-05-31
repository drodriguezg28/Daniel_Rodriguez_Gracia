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

        <div class="row g-3">
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Nombre</label>
                <p>{{ $usuario->name }}</p>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Email</label>
                <p>{{ $usuario->email }}</p>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Tipo de Usuario</label>
                </p>{{ $usuario->tipo_usuario }}</p>
            </div>
        </div>

        <a href="{{ route('usuarios.editar', ['id' => $usuario->id]) }}" class="btn btn-primary mt-4">Editar Datos</a>
        <a href="{{ route('usuarios.principal') }}" class="btn btn-secondary mt-4">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
        

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
