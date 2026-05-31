@extends('components.layouts.config_layout')
@section('title', 'Crear Partido')



@section('content')

<div class="container mt-4 bg-white p-4 rounded ">
    <h2 class="h4 mb-4 text-dark">Crear partido</h2>
    
    <form action="{{ route('partidos.crear') }}" method="POST">
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
                    <option value="">Selecciona un Club ...</option>
                    @foreach ($clubes as $club)
                        <option value="{{ $club->ID_Club }}" {{ old('Local') == $club->ID_Club ? 'selected' : '' }}>
                            {{ $club->Nombre }} ({{ $club?->pais?->Nombre }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Equipo Visitante</label>
                <select name="Visitante" class="form-select">
                    <option value="">Selecciona un Club ...</option>
                    @foreach ($clubes as $club)
                        <option value="{{ $club->ID_Club }}" {{ old('Visitante') == $club->ID_Club ? 'selected' : '' }}>
                            {{ $club->Nombre }} ({{ $club?->pais?->Nombre }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Goles Local</label>
                <div class="input-group">
                    <input type="number" name="Goles_Local" step="0" min="0" max="99" value="{{ old('Goles_Local') }}" class="form-control">
                    <span class="input-group-text">Goles</span>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Goles Visitante</label>
                <div class="input-group">
                    <input type="number" name="Goles_Visitante" step="0" min="0" max="99" value="{{ old('Goles_Visitante') }}" class="form-control">
                    <span class="input-group-text">Goles</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Fecha del Partido</label>
                <input type="date" name="Fecha" value="{{ old('Fecha') }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Localidad</label>
                <input type="text" name="Localidad" value="{{ old('Localidad') }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Pais</label>
                <select name="Pais" class="form-select">
                    <option value="">Seleccione un país...</option>
                    @foreach ($paises as $pais)
                        <option value="{{ $pais->ID_Pais }}">
                            {{ $pais->Nombre }} ({{ $pais->Continente }})
                        </option>
                    @endforeach
                </select>
            </div>


        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4 ">
                Añadir Datos
            </button>
            <a href="{{ route('partidos.principal') }}" class="btn btn-secondary px-4">
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
