@extends('components.layouts.config_layout')
@section('title', 'Editar Partido')



@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded ">
    <h2 class="h4 mb-4 text-dark">Editar Partido: {{ $partido?->Local?->Nombre }} vs {{ $partido?->Visitante?->Nombre }}</h2>
    
    <form action="{{ route('partidos.actualizar', ['id' => $partido->ID_Partido_Cubierto]) }}" method="POST">
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
                <label class="form-label fw-bold small text-secondary">Equipo Local</label>
                <select name="Local" class="form-select">
                    @foreach ($clubes as $club)
                    <option value="{{ $club->ID_Club }}" {{ $partido?->Local?->ID_Club == $club->ID_Club ? 'selected' : '' }}>
                        {{ $club->Nombre }} ({{ $club?->pais?->Nombre }})
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Equipo Visitante</label>
                <select name="Visitante" class="form-select">
                    @foreach ($clubes as $club)
                    <option value="{{ $club->ID_Club }}" {{ $partido?->Visitante?->ID_Club == $club->ID_Club ? 'selected' : '' }}>
                        {{ $club->Nombre }} ({{ $club?->pais?->Nombre }})
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Goles Local</label>
                <div class="input-group">
                    <input type="number" name="Goles_Local" step="0" value="{{ old('Goles_Local', $partido->Goles_Local) }}" class="form-control">
                    <span class="input-group-text">goles</span>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Goles Visitante</label>
                <div class="input-group">
                    <input type="number" name="Goles_Visitante" step="0" value="{{ old('Goles_Visitante', $partido->Goles_Visitante) }}" class="form-control">
                    <span class="input-group-text">goles</span>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Nacionalidad</label>
                <select name="Pais" class="form-select">
                    <option value="">Seleccione un país...</option>
                    @foreach ($paises as $pais)
                        <option value="{{ $pais->ID_Pais }}" {{ $partido->Pais == $pais->ID_Pais ? 'selected' : '' }}>
                            {{ $pais->Nombre }} ({{ $pais->Continente }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Localidad</label>
                <input type="text" name="Localidad" value="{{ old('Localidad', $partido->Localidad) }}" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Fecha del Partido</label>
                <input type="date" name="Fecha" value="{{ old('Fecha', $partido->Fecha) }}" class="form-control">
            </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4 ">
                Actualizar Datos
            </button>
            <a href="{{ route('partidos.ver', ['id' => $partido->ID_Partido_Cubierto]) }}" class="btn btn-secondary px-4">
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
