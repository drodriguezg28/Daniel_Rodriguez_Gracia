@extends('components.layouts.config_layout')

@section('title', 'Inicio')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold mb-0">Panel de Administración</h3>
    <p class="text-muted small mb-0">Bienvenido, <strong>{{ Auth::user()->name }}</strong> &mdash; Vista general del sistema</p>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top: 4px solid #0d6efd;">
            <i class="bi bi-person-badge text-primary fs-2 mb-1"></i>
            <div class="h2 fw-bold text-primary mb-0">{{ $totaljugadores }}</div>
            <div class="small text-muted">Jugadores</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top: 4px solid #198754;">
            <i class="bi bi-binoculars text-success fs-2 mb-1"></i>
            <div class="h2 fw-bold text-success mb-0">{{ $totalojeadores }}</div>
            <div class="small text-muted">Ojeadores</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top: 4px solid #dc3545;">
            <i class="bi bi-journal-text text-danger fs-2 mb-1"></i>
            <div class="h2 fw-bold text-danger mb-0">{{ $totalinformes }}</div>
            <div class="small text-muted">Informes</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top: 4px solid #fd7e14;">
            <i class="bi bi-person-lines-fill text-warning fs-2 mb-1"></i>
            <div class="h2 fw-bold text-warning mb-0">{{ $totalagentes }}</div>
            <div class="small text-muted">Agentes</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3">
            <i class="bi bi-shield text-secondary fs-2 mb-1"></i>
            <div class="h2 fw-bold mb-0">{{ $totalclubes }}</div>
            <div class="small text-muted">Clubes</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3">
            <i class="bi bi-trophy text-secondary fs-2 mb-1"></i>
            <div class="h2 fw-bold mb-0">{{ $totalcompeticiones }}</div>
            <div class="small text-muted">Competiciones</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3">
            <i class="bi bi-people text-secondary fs-2 mb-1"></i>
            <div class="h2 fw-bold mb-0">{{ $totalusuarios }}</div>
            <div class="small text-muted">Usuarios</div>
        </div>
    </div>
</div>

{{-- Últimos informes --}}
@if($ultimosinformes->count() > 0)
<div class="card border-0 shadow-sm rounded-3 mt-4">
    <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Últimos Informes Creados</h6>
        <a href="{{ route('informes.principal') }}" class="btn btn-outline-primary btn-sm">Ver todos</a>
    </div>
    <div class="list-group list-group-flush">
        @foreach($ultimosinformes as $informe)
        @php $partido = $informe->partido; @endphp
        <a href="{{ route('informes.ver', ['id' => $informe->ID_Informe]) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 px-3">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ $partido?->Local?->url_logo }}" style="width:1.4em; height:1.4em; object-fit:contain;">
                <span class="small fw-semibold">
                    {{ $partido?->Local?->Nombre }} {{ $partido?->Goles_Local }} vs {{ $partido?->Goles_Visitante }} {{ $partido?->Visitante?->Nombre }}
                </span>
                <img src="{{ $partido?->Visitante?->url_logo }}" style="width:1.4em; height:1.4em; object-fit:contain;">
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="small text-muted">{{ $informe->ojeador?->Nombre }} {{ $informe->ojeador?->Apellido1 }}</span>
                <span class="badge bg-secondary">{{ $informe->created_at ? \Carbon\Carbon::parse($informe->created_at)->format('d/m/Y') : '' }}</span>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

@endsection
