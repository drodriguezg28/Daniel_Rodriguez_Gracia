@extends('components.layouts.config_layout')
@section('title', 'Editar Informe')

@php
    $potenciales = [
        'Bajo', 'Medio', 'Alto', 'Élite', 'Generacional', 'Estable', 'En Declive', 'Últimos Años'
    ];
@endphp

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded">
    <h2 class="h4 mb-4 text-dark">Editar Informe</h2>

    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('informes.actualizar', ['id' => $informe->ID_Informe]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Jugador Analizado</label>
                <select name="ID_Jugador" class="form-select">
                    <option value="">Seleccione un jugador...</option>
                    @foreach ($jugadores as $jugador)
                        <option value="{{ $jugador->ID_Jugador }}" {{ $informe->Jugador == $jugador->ID_Jugador ? 'selected' : '' }}>
                            {{ $jugador->Nombre }} {{ $jugador->Apellido1 }} {{ $jugador->Apellido2 }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Ojeador</label>
                <select name="ID_Ojeador" class="form-select">
                    <option value="">Seleccione un ojeador...</option>
                    @foreach ($ojeadores as $ojeador)
                        <option value="{{ $ojeador->ID_Ojeador }}" {{ $informe->Ojeador == $ojeador->ID_Ojeador ? 'selected' : '' }}>
                            {{ $ojeador->Nombre }} {{ $ojeador->Apellido1 }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Partido Analizado</label>
                <select name="ID_Partido" class="form-select">
                    <option value="">Seleccione un partido...</option>
                    @foreach ($partidos as $partido)
                        <option value="{{ $partido->ID_Partido_Cubierto }}" {{ $informe->Partido_Cubierto == $partido->ID_Partido_Cubierto ? 'selected' : '' }}>
                            {{ $partido?->Local?->Nombre }} {{ $partido->Goles_Local }} - {{ $partido->Goles_Visitante }} {{ $partido?->Visitante?->Nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Fecha del Informe</label>
                <input type="date" name="Fecha_Informe" value="{{ old('Fecha_Informe', $informe->Fecha_Informe) }}" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Potencial</label>
                <select name="Potencial" class="form-select">
                    <option value="">Seleccione valoración...</option>
                    @foreach ($potenciales as $valor)
                        <option value="{{ $valor }}" {{ $informe->Potencial == $valor ? 'selected' : '' }}>
                            {{ $valor }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold small text-secondary">Observaciones</label>
                <textarea name="Valoraciones" rows="10" class="form-control" placeholder="Describe los puntos fuertes, debilidades y comportamiento táctico...">{{ old('Valoraciones', $informe->Valoraciones) }}</textarea>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-primary px-4">
                Actualizar Informe
            </button>
            <a href="{{ route('informes.ver', ['id' => $informe->ID_Informe]) }}" class="btn btn-secondary px-4 ms-2">
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
        height: 2.6em;
    }
    textarea.form-control{
        height:auto;
    }
    .nav-link { color: #cbd5e1; }
</style>
@endsection