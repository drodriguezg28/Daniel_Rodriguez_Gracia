@extends('components.layouts.config_layout')
@section('title', 'Inicio')

@section('content')

{{-- Header de bienvenida --}}
<div class="card border-0 mb-4 text-white"
     style="background: linear-gradient(135deg, #1a2a4d 0%, #2b4a8a 60%, #4a72c4 100%); border-radius: 16px;">
    <div class="card-body p-4 d-flex align-items-center gap-4">
        <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center border border-3 border-white flex-shrink-0"
             style="width:70px; height:70px;">
            <i class="bi bi-person-lines-fill text-white fs-2"></i>
        </div>
        <div>
            <p class="mb-0 text-white text-opacity-75 small text-uppercase fw-semibold">Bienvenido</p>
            <h2 class="fw-bold mb-0">{{ $agente->Nombre }} {{ $agente->Apellido1 }} {{ $agente->Apellido2 }}</h2>
        </div>
    </div>
</div>

{{-- Métricas rápidas --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top:4px solid #0d6efd;">
            <i class="bi bi-person-badge text-primary fs-2 mb-1"></i>
            <div class="h2 fw-bold text-primary mb-0">{{ $cuentajugadores }}</div>
            <div class="small text-muted">Jugadores</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top:4px solid #198754;">
            <i class="bi bi-bullseye text-success fs-2 mb-1"></i>
            <div class="h2 fw-bold text-success mb-0">{{ $totalGoles }}</div>
            <div class="small text-muted">Goles (cartera)</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top:4px solid #0dcaf0;">
            <i class="bi bi-arrow-right-circle text-info fs-2 mb-1"></i>
            <div class="h2 fw-bold text-info mb-0">{{ $totalAsistencias }}</div>
            <div class="small text-muted">Asistencias (cartera)</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3" style="border-top:4px solid #fd7e14;">
            <i class="bi bi-currency-euro text-warning fs-2 mb-1"></i>
            <div class="h5 fw-bold text-warning mb-0">
                @if($valorTotal >= 1000000)
                    {{ number_format($valorTotal / 1000000, 1) }}M &euro;
                @elseif($valorTotal > 0)
                    {{ number_format($valorTotal / 1000, 0) }}K &euro;
                @else
                    &mdash;
                @endif
            </div>
            <div class="small text-muted">Valor de cartera</div>
        </div>
    </div>
</div>

{{-- Listado de jugadores como tarjetas --}}
<h5 class="fw-bold mb-3"><i class="bi bi-person-badge me-2 text-primary"></i>Mis Jugadores</h5>

@if($jugadores->count() > 0)
<div class="row g-3">
    @foreach ($jugadores as $jugador)
        <div class="col-md-6 col-xl-4">
            <a href="{{ route('jugadores.ver', ['id' => $jugador->ID_Jugador]) }}" class="text-decoration-none text-dark">
                <div class="card border-0 shadow-sm h-100 rounded-3">
                    <div class="card-body d-flex align-items-center gap-3">
                        <img src="{{ $jugador->Foto_Perfil }}"
                             onerror="this.src='{{ asset('img/player-fallback-dark.png') }}';"
                             alt="{{ $jugador->Nombre }}"
                             class="rounded-circle flex-shrink-0"
                             style="width:50px; height:50px; object-fit:cover;">
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-bold text-truncate">
                                {{ $jugador->Nombre }} {{ $jugador->Apellido1 }}
                                @php $apodo = trim($jugador->Apodo); @endphp
                                @if(!empty($apodo) && $apodo !== '-')
                                    <span class="text-muted fw-normal">"{{ $apodo }}"</span>
                                @endif
                            </div>
                            <div class="small text-muted">{{ $jugador->Posicion_Principal ?? '—' }}</div>
                            <div class="d-flex align-items-center gap-1 mt-1">
                                @if($jugador->Club?->url_logo)
                                    <img src="{{ $jugador->Club->url_logo }}" style="width:1em; object-fit:contain;">
                                @endif
                                <span class="small text-muted">{{ $jugador->Club?->Nombre ?? 'Sin club' }}</span>
                            </div>
                        </div>
                        <div class="text-center flex-shrink-0">
                            @if($jugador->pais?->Bandera)
                                <img src="{{ asset($jugador->pais->Bandera) }}" style="width:1.5em;" title="{{ $jugador->pais->Nombre }}">
                            @endif
                            @if($jugador->Dorsal_actual)
                                <div class="mt-1">
                                    <span class="badge bg-secondary">#{{ $jugador->Dorsal_actual }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@else
<div class="card border-0 shadow-sm text-center py-5 rounded-3">
    <i class="bi bi-person-badge text-muted fs-1 opacity-25"></i>
    <p class="mt-3 text-muted mb-0">Aún no tienes jugadores asignados.</p>
</div>
@endif

@endsection
