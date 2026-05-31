@extends('components.layouts.config_layout')
@section('title', 'Ver Competición')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h4 mb-0 text-dark">
            <i class="bi bi-trophy me-2 text-primary"></i>
            {{ $competicion->Nombre }}
        </h2>
        @if(Auth::user()->tipo_usuario === 'admin')
            <a href="{{ route('competiciones.editar', ['id' => $competicion->ID_Competicion]) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i>Editar Datos
            </a>
        @endif
    </div>

    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">Nombre</label>
            <p>{{ $competicion->Nombre }}</p>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">Tipo</label>
            <p>
                <span class="badge bg-primary">{{ $competicion->Tipo }}</span>
            </p>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">País</label>
            @if($competicion->pais)
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $competicion?->pais?->Bandera }}" alt="Bandera"
                         style="width: 1.7em; height: 1em; border: 0.1em solid #eee;">
                    <span>{{ $competicion?->pais?->Nombre }} ({{ $competicion?->pais?->Continente }})</span>
                </div>
            @else
                <p class="text-muted fst-italic">Sin país asociado (competición internacional)</p>
            @endif
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">Clubes Participantes</label>
            @if($competicion->clubes->count() > 0)
                <div class="d-flex flex-wrap gap-2 mt-1">
                    @foreach($competicion->clubes as $club)
                        <div class="d-flex align-items-center border rounded px-2 py-1 bg-light">
                            <img src="{{ $club->url_logo }}" alt="{{ $club->Nombre }}"
                                 style="width: 1.5em; height: 1.5em; object-fit: contain;" class="me-1">
                            <small>{{ $club->Nombre }}</small>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted fst-italic">Sin clubes registrados</p>
            @endif
        </div>

    </div>

    <div class="mt-4 pt-3 border-top d-flex gap-2">
        @if(Auth::user()->tipo_usuario === 'admin')
            <a href="{{ route('competiciones.editar', ['id' => $competicion->ID_Competicion]) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i>Editar Datos
            </a>
        @endif
        <a href="{{ route('competiciones.principal') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Volver
        </a>
    </div>
</div>

<style>
    body {
        background-color: #f4f7f6;
        font-family: 'Open Sans', sans-serif;
    }
    img { width: 1.5em; }
</style>
@endsection
