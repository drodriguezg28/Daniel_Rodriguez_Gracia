@extends('components.layouts.config_layout')
@section('title', 'Mi Dashboard')

@section('content')

{{-- Cabecera de bienvenida --}}
<div class="card border-0 mb-4 text-white rounded-3"
     style="background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 60%, #4a90d9 100%);">
    <div class="card-body p-3 p-md-4 d-flex flex-wrap align-items-center gap-3">
        <div>
            @if($jugador->Foto_Perfil)
                <img src="{{ $jugador->Foto_Perfil }}"
                     onerror="this.src='{{ asset('img/player-fallback-dark.png') }}';"
                     alt="{{ $jugador->Nombre }}"
                     class="rounded-circle border border-3 border-white"
                     style="width:70px; height:70px; object-fit:cover;">
            @else
                <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center border border-3 border-white"
                     style="width:70px; height:70px;">
                    <i class="bi bi-person-fill text-white fs-2"></i>
                </div>
            @endif
        </div>
        <div class="flex-grow-1">
            <p class="mb-0 text-white text-opacity-75 small text-uppercase fw-semibold">Bienvenido de nuevo</p>
            <h2 class="fw-bold mb-1 fs-4">
                {{ $jugador->Nombre }} {{ $jugador->Apellido1 }}
                @if($jugador->Apodo && trim($jugador->Apodo) !== '-')
                    <span class="text-warning fs-5">"{{ $jugador->Apodo }}"</span>
                @endif
            </h2>
            <div class="d-flex flex-wrap gap-2">
                @if($jugador->club)
                    <span class="small">
                        <img src="{{ $jugador->club->url_logo }}" alt="{{ $jugador->club->Nombre }}" style="width:1.2em; height:1.2em; object-fit:contain;" class="me-1">
                        {{ $jugador->club->Nombre }}
                    </span>
                @endif
                <span class="small"><i class="bi bi-geo-alt me-1"></i>{{ $jugador->Posicion_Principal ?? '—' }}</span>
                @if($jugador->Dorsal_actual)
                    <span class="badge bg-white text-dark fw-bold">#{{ $jugador->Dorsal_actual }}</span>
                @endif
            </div>
        </div>
        <a href="{{ route('jugador.perfil') }}" class="btn btn-light btn-sm fw-semibold">
            <i class="bi bi-pencil-square me-1"></i> Editar perfil
        </a>
    </div>
</div>

{{-- Tarjetas de estadísticas totales --}}
@php
    $totalPartidos    = $jugador->estadisticas->sum('Partidos_jugados');
    $totalGoles       = $jugador->estadisticas->sum('Goles');
    $totalAsistencias = $jugador->estadisticas->sum('Asistencias');
    $totalAmarillas   = $jugador->estadisticas->sum('Tarjetas_amarillas');
@endphp

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3">
            <div class="h2 fw-bold text-primary mb-0">{{ $totalPartidos }}</div>
            <div class="small text-muted mt-1"><i class="bi bi-controller me-1"></i>Partidos</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3">
            <div class="h2 fw-bold text-success mb-0">{{ $totalGoles }}</div>
            <div class="small text-muted mt-1"><i class="bi bi-bullseye me-1"></i>Goles</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3">
            <div class="h2 fw-bold text-info mb-0">{{ $totalAsistencias }}</div>
            <div class="small text-muted mt-1"><i class="bi bi-arrow-right-circle me-1"></i>Asistencias</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3 rounded-3">
            <div class="h2 fw-bold text-warning mb-0">{{ $totalAmarillas }}</div>
            <div class="small text-muted mt-1"><i class="bi bi-square-fill text-warning me-1"></i>Amarillas</div>
        </div>
    </div>
</div>

{{-- Estadísticas por temporada --}}
@if($jugador->estadisticas->count() > 0)
<div class="card border-0 shadow-sm mb-4 rounded-3">
    <div class="card-header bg-white border-0 pt-3 pb-2">
        <h5 class="fw-bold mb-0"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Mis Estadísticas</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Temporada</th>
                        <th>Competición</th>
                        <th>Club</th>
                        <th class="text-center">PJ</th>
                        <th class="text-center">G</th>
                        <th class="text-center">A</th>
                        <th class="text-center"><span class="badge bg-warning text-dark">TA</span></th>
                        <th class="text-center"><span class="badge bg-danger">TR</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jugador->estadisticas->sortByDesc(fn($e) => $e->temporada?->Nombre_Temporada ?? '') as $stat)
                    <tr>
                        <td class="ps-3 fw-semibold text-primary">{{ $stat->temporada?->Nombre_Temporada ?? '—' }}</td>
                        <td>{{ $stat->competicion?->Nombre ?? '—' }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                @if($stat->club?->url_logo)
                                    <img src="{{ $stat->club->url_logo }}" style="width:1.2em; height:1.2em; object-fit:contain;">
                                @endif
                                <small>{{ $stat->club?->Nombre ?? '—' }}</small>
                            </div>
                        </td>
                        <td class="text-center">{{ $stat->Partidos_jugados }}</td>
                        <td class="text-center fw-bold">{{ $stat->Goles }}</td>
                        <td class="text-center">{{ $stat->Asistencias }}</td>
                        <td class="text-center">
                            @if($stat->Tarjetas_amarillas > 0)
                                <span class="badge bg-warning text-dark">{{ $stat->Tarjetas_amarillas }}</span>
                            @else <span class="text-muted">0</span> @endif
                        </td>
                        <td class="text-center">
                            @if($stat->Tarjetas_rojas > 0)
                                <span class="badge bg-danger">{{ $stat->Tarjetas_rojas }}</span>
                            @else <span class="text-muted">0</span> @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="card border-0 shadow-sm text-center py-5 mb-4 rounded-3">
    <i class="bi bi-bar-chart text-muted fs-1 opacity-25"></i>
    <p class="mt-3 text-muted mb-0">Aún no tienes estadísticas registradas.</p>
</div>
@endif

@endsection
