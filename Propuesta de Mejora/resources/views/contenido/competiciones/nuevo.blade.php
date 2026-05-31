@extends('components.layouts.config_layout')
@section('title', 'Nueva Competición')

@php
    $tipos = [
        'Liga', 'Copa Nacional', 'Copa de la Liga', 'Supercopa',
        'Copa Continental', 'Copa Intercontinental', 'Torneo Amistoso'
    ];
@endphp

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded">
    <h2 class="h4 mb-4 text-dark">Nueva Competición</h2>

    <form action="{{ route('competiciones.crear') }}" method="POST">
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
                <input type="text" name="Nombre"
                       value="{{ old('Nombre') }}"
                       class="form-control" required placeholder="Ej: La Liga, Champions League...">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Tipo</label>
                <select name="Tipo" class="form-select" required>
                    <option value="">Seleccione un tipo...</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo }}" {{ old('Tipo') === $tipo ? 'selected' : '' }}>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">País <span class="text-muted fw-normal">(opcional, dejar vacío si es internacional)</span></label>
                <select name="Pais" class="form-select">
                    <option value="">Sin país (internacional)</option>
                    @foreach($paises as $pais)
                        <option value="{{ $pais->ID_Pais }}" {{ old('Pais') == $pais->ID_Pais ? 'selected' : '' }}>
                            {{ $pais->Nombre }} ({{ $pais->Continente }})
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-plus-lg me-1"></i>Crear Competición
            </button>
            <a href="{{ route('competiciones.principal') }}" class="btn btn-secondary px-4">
                <i class="bi bi-arrow-left me-1"></i>Volver
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
