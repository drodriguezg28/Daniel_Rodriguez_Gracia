@extends('components.layouts.config_layout')
@section('title', 'Ver Partido')

<style>
    
    img{
        
        width: 1.5rem;
    }
    </style>

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded ">
    <h2 class="h4 mb-4 text-dark">Datos del Partido {{ $partido?->Local?->Nombre }} vs {{ $partido?->Visitante?->Nombre }} </h2>
    
    <div class="row g-3">
        
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Equipo Local</label>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $partido?->Local?->url_logo }}" alt="{{ $partido?->Local?->Nombre }}">
                    <span>{{ $partido?->Local?->Nombre }}</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Equipo Visitante</label>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $partido?->Visitante?->url_logo }}" alt="{{ $partido?->Visitante?->Nombre }}">
                    <span>{{ $partido?->Visitante?->Nombre }}</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Goles Local</label>
                <p>{{ $partido->Goles_Local }}</p>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Goles Visitante</label>
                <p>{{ $partido->Goles_Visitante }}</p>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Ganador</label>
                <div>
                    @if($partido->Ganador === 'Local')
                        <span class="badge rounded-pill bg-primary-subtle text-primary fs-6">
                            <i class="bi bi-trophy-fill me-1"></i> {{ $partido?->Local?->Nombre }}
                        </span>
                    @elseif($partido->Ganador === 'Visitante')
                        <span class="badge rounded-pill bg-danger-subtle text-danger fs-6">
                            <i class="bi bi-trophy-fill me-1"></i> {{ $partido?->Visitante?->Nombre }}
                        </span>
                    @else
                        <span class="badge rounded-pill bg-secondary-subtle text-secondary fs-6">
                            <i class="bi bi-dash-circle me-1"></i> Empate
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Fecha</label>
                <p>{{ \Carbon\Carbon::parse($partido->Fecha)->format('d-m-Y') }}</p>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">País</label>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $partido?->pais?->Bandera }}" alt="">
                    <span>{{ $partido?->pais?->Nombre }} ({{ $partido?->pais?->Continente }})</span>
                </div>
                
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Localidad</label>
                <p>{{ $partido->Localidad }}</p>
            </div>
            
        </div>
        
        <div class="mt-4 pt-3 border-top">
            <a href="{{ route('partidos.editar',['id' => $partido->ID_Partido_Cubierto]) }}" class="btn btn-primary">
                Editar Datos
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
