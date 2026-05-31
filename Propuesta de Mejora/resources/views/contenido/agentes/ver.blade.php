@extends('components.layouts.config_layout')
@section('title', 'Ver Datos de Agente')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded ">
    <h2 class="h4 mb-4 text-dark">Ver Perfil de <strong>{{$agente->Nombre}} {{ $agente->Apellido1 }} {{ $agente->Apellido2 }}</strong></h2>
    
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">Nombre</label>
            <p>{{ $agente->Nombre }}</p>
        </div>
        
        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">Primer Apellido</label>
            <p>{{ $agente->Apellido1 }}</p>
        </div>
        
        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">Segundo Apellido</label>
            <p>{{ $agente->Apellido2 }}</p>
        </div>
        
        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">País</label>
            <div class="d-flex align-items-center">
                <img src="{{ $agente?->Pais?->Bandera }}" alt="{{ $agente?->Pais?->Nombre }}" class="me-1" style="width: 1.7em; height: 1em; border: 0.1em solid #eee;">
                <span>{{ $agente?->Pais?->Nombre }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-bold small text-secondary">Usuario vinculado</label>
            @if($agente->Usuario)
                <p>{{ $agente?->Usuario?->name }} ({{ $agente?->Usuario?->email }})</p>
            @else
                <p class="text-muted ">Sin usuario vinculado</p>
            @endif
        </div>
        
    </div>

    @if (Auth::user()->tipo_usuario === 'admin' or Auth::user()->id === $agente->Usuario )
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <a href="{{ route('agentes.editar', ['id' => $agente->ID_Agente]) }}" class="btn btn-primary">Editar Datos</a>
            <a href="{{ route('agentes.principal') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    @else
        <div class="mt-4 pt-3 border-top">
            <a href="{{ route('agentes.principal') }}" class="btn btn-secondary">
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
