@extends('components.layouts.config_layout')
@section('title', 'Ver Datos de Club')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded ">
    <h2 class="h4 mb-4 text-dark">Ver Perfil de <strong>{{ $club->Nombre }}</strong></h2>
    
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">Nombre</label>
            <div class="d-flex align-items-center">
                <img src="{{ $club->url_logo }}" alt="Bandera {{ $club?->pais?->Nombre }}"  class="me-1" style="width: 2em;">
                <p>{{ $club->Nombre }}</p>
            </div>
        </div>
        
        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">País</label>
            <div class="d-flex align-items-center">
                <img src="{{ $club?->pais?->Bandera }}" alt="Bandera {{ $club?->pais?->Nombre }}"  class="me-1" style="width: 1.7em; height: 1em; border: 0.1em solid #eee;">
                <span>{{ $club?->pais?->Nombre }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">Usuario vinculado</label>
            @if($club->Usuario)
                <p>{{ $club?->Usuario?->name }} ({{ $club?->Usuario?->email }})</p>
            @else
                <p class="text-muted ">Sin usuario vinculado</p>
            @endif
        </div>
        
    </div>

    @if (Auth::user()->tipo_usuario === 'admin' or Auth::user()->id === $club->Usuario)
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <a href="{{ route('clubes.editar', ['id' => $club->ID_Club]) }}" class="btn btn-primary">Editar Datos</a>
            <a href="{{ route('clubes.principal') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    @else
        <div class="mt-4 pt-3 border-top">
            <a href="{{ route('clubes.principal') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    @endif
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
