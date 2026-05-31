@extends('components.layouts.config_layout')
@section('title', 'Inicio')

@section('content')

{{-- Header de bienvenida --}}
<div class="card border-0 mb-4 text-white"
     style="background: linear-gradient(135deg, #1a3d2b 0%, #2e7d52 60%, #4caf7d 100%); border-radius: 16px;">
    <div class="card-body p-4 d-flex align-items-center gap-4">
        <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center border border-3 border-white flex-shrink-0"
             style="width:70px; height:70px;">
            <i class="bi bi-binoculars-fill text-white fs-2"></i>
        </div>
        <div>
            <p class="mb-0 text-white text-opacity-75 small text-uppercase fw-semibold">Bienvenido</p>
            <h2 class="fw-bold mb-1">
                {{ $ojeador->Nombre }} {{ $ojeador->Apellido1 }} {{ $ojeador->Apellido2 }}
                @if($ojeador->Apodo && trim($ojeador->Apodo) !== '-')
                    <span class="text-warning fs-5">"{{ $ojeador->Apodo }}"</span>
                @endif
            </h2>
        </div>
    </div>
</div>

{{-- Métricas rápidas --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top:4px solid #198754;">
            <i class="bi bi-journal-text text-success fs-2 mb-1"></i>
            <div class="h2 fw-bold text-success mb-0">{{ $cuentainformes }}</div>
            <div class="small text-muted">Informes creados</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top:4px solid #0d6efd;">
            <i class="bi bi-person-badge text-primary fs-2 mb-1"></i>
            <div class="h2 fw-bold text-primary mb-0">{{ $jugadoresUnicos }}</div>
            <div class="small text-muted">Jugadores evaluados</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top:4px solid #fd7e14;">
            <i class="bi bi-shield-check text-warning fs-2 mb-1"></i>
            <div class="h2 fw-bold text-warning mb-0">{{ $partidosCubiertos }}</div>
            <div class="small text-muted">Partidos cubiertos</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top:4px solid #6f42c1;">
            <i class="bi bi-clock-history fs-2 mb-1" style="color:#6f42c1;"></i>
            <div class="small fw-bold mb-0" style="color:#6f42c1;">
                @if($ultimoInforme)
                    {{ \Carbon\Carbon::parse($ultimoInforme->created_at)->format('d/m/Y') }}
                @else
                    &mdash;
                @endif
            </div>
            <div class="small text-muted">Último informe</div>
        </div>
    </div>
</div>

{{-- Listado de informes como tarjetas --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-journal-text me-2 text-success"></i>Mis Informes</h5>
    <a href="{{ route('informes.creacion') }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Informe
    </a>
</div>

@if($informesojeador->count() > 0)
<div class="row g-3">
    @foreach ($informesojeador as $informe)
        @php $partido = $informe->partido; @endphp
        @php $jugador = $informe->jugador; @endphp
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('informes.ver', ['id' => $informe->ID_Informe]) }}" class="text-decoration-none text-dark">
                <div class="card border-0 shadow-sm h-100 rounded-3">
                    <div class="card-body">
                        {{-- Partido --}}
                        @if($partido)
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-2 p-2 bg-light rounded">
                            <img src="{{ $partido?->Local?->url_logo }}" alt="{{ $partido?->Local?->Nombre }}"
                                 style="width:2em; height:2em; object-fit:contain;">
                            <span class="fw-bold">
                                {{ $partido?->Goles_Local }} <span class="text-muted fw-normal small">vs</span> {{ $partido?->Goles_Visitante }}
                            </span>
                            <img src="{{ $partido?->Visitante?->url_logo }}" alt="{{ $partido?->Visitante?->Nombre }}"
                                 style="width:2em; height:2em; object-fit:contain;">
                        </div>
                        <p class="small text-muted text-center mb-2">
                            {{ $partido?->Local?->Nombre }} vs {{ $partido?->Visitante?->Nombre }}
                        </p>
                        @endif

                        {{-- Jugador evaluado --}}
                        @if($jugador)
                        <div class="d-flex align-items-center gap-2 pt-2 border-top">
                            <img src="{{ $jugador->Foto_Perfil }}"
                                 onerror="this.src='{{ asset('img/player-fallback-dark.png') }}';"
                                 alt="{{ $jugador->Nombre }}"
                                 class="rounded-circle"
                                 style="width:2em; height:2em; object-fit:cover;">
                            <div>
                                <div class="fw-semibold small">{{ $jugador->Nombre }} {{ $jugador->Apellido1 }}</div>
                                <div class="d-flex align-items-center gap-1">
                                    <img src="{{ $jugador?->Club?->url_logo }}" style="width:1em;">
                                    <span class="text-muted small">{{ $jugador?->Club?->Nombre }}</span>
                                </div>
                            </div>
                            <img src="{{ $jugador?->pais?->Bandera }}" style="width:1.3em;" class="ms-auto">
                        </div>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@else
<div class="card border-0 shadow-sm text-center py-5 rounded-3">
    <i class="bi bi-journal text-muted fs-1 opacity-25"></i>
    <p class="mt-3 text-muted mb-2">Aún no has creado ningún informe.</p>
    <a href="{{ route('informes.creacion') }}" class="btn btn-success btn-sm mx-auto">
        Crear mi primer informe
    </a>
</div>
@endif

@endsection
