@extends('components.layouts.config_layout')
@section('title', 'Editar Agente')


@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded ">
    <h2 class="h4 mb-4 text-dark">Editar Perfil de {{$agente->Nombre}} {{ $agente->Apellido1 }} {{ $agente->Apellido2 }}</h2>
    
    <form action="{{ route('agentes.actualizar', ['id' => $agente->ID_Agente]) }}" method="POST">
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
                <input type="text" name="Nombre" value="{{ old('Nombre', $agente->Nombre) }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Primer Apellido</label>
                <input type="text" name="Apellido1" value="{{ old('Apellido1', $agente->Apellido1) }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Segundo Apellido</label>
                <input type="text" name="Apellido2" value="{{ old('Apellido2', $agente->Apellido2) }}" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">País</label>
                <select name="Pais" class="form-select">
                    <option value="">Seleccione un país...</option>
                    @foreach ($paises as $pais)
                        <option value="{{ $pais->ID_Pais }}" {{ $agente->Nacionalidad == $pais->ID_Pais ? 'selected' : '' }}>
                            {{ $pais->Nombre }} ({{ $pais->Continente }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Usuarios</label>
                <select name="Usuario" class="form-select">
                    <option value="">Seleccione un Usuario...</option>
                    @forelse ($usuarios as $usuario)
                        <option value="{{ $usuario->ID_Usuario }}" @selected(old('ID_Agente', $agente->Usuario) == $usuario->ID_Usuario)>
                            {{ $usuario->name}} ({{ $usuario->email}})
                        </option>
                    @empty
                        <option value="">No hay usuarios</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                Actualizar Datos
            </button>
            <a href="{{ route('agentes.ver', ['id' => $agente->ID_Agente]) }}" class="btn btn-secondary px-4">
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
