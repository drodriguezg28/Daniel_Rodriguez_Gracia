@extends('components.layouts.config_layout')
@section('title', 'Ver Informe')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <div class="card border-0  rounded-3">
        <div class="card-body p-4 p-md-5">

            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <h2 class="h4 mb-0 text-dark fw-bold">Ver Informe</h2>
                @if (Auth::user()->tipo_usuario === 'admin' or Auth::user()->id === $informe?->ojeador?->Usuario)
                    <a href="{{ route('informes.editar', ['id' => $informe->ID_Informe]) }}" class="btn btn-primary px-4">Editar Datos</a>
                @endif
            </div>

            @php
                $jugador = $informe->jugador;
                $ojeador = $informe->ojeador;
                $partido = $informe->partido;
                $local = $informe?->partido?->Local;
                $visitante = $informe?->partido?->Visitante;
                $PorDefecto = asset('img/player-fallback-dark.png');
            @endphp

            <div class="row g-4 align-items-start">
                
                <div class="col-12 col-xl-6">
                    <label class="text-muted fw-bold small mb-2">JUGADOR</label>
                    <a href="{{ route('jugadores.ver', ['id' => $jugador]) }}" class="list-group-item list-group-item-actionborder-2 rounded-4 overflow-hidden">
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $jugador->Foto_Perfil }}" onerror="this.src='{{ $PorDefecto }}';" alt="Foto" style="width: 2.5rem; height: 3rem; object-fit: cover;" class="rounded border">
                                <span class="fw-semibold fs-5 text-dark">{{ $jugador->Nombre }} {{ $jugador->Apellido1 }} {{ $jugador->Apellido2 }}</span>
                            </div>

                            <div class="d-flex gap-2">
                                <span class="badge bg-light text-dark border d-flex align-items-center gap-2 px-2 py-1 fw-normal fs-6">
                                    <img src="{{ $jugador?->pais?->Bandera }}" alt="Bandera" style="width: 1.2rem;">
                                    {{ $jugador?->pais?->Nombre }}
                                </span>
                                <span class="badge bg-light text-dark border d-flex align-items-center gap-2 px-2 py-1 fw-normal fs-6">
                                    <img src="{{ $jugador?->Club?->url_logo }}" alt="Logo" style="width: 1.2rem;">
                                    {{ $jugador?->Club?->Nombre }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-xl-6">
                    <label class="text-muted fw-bold small mb-2 d-block">PARTIDO</label>
                    <a href="{{ route('partidos.ver', ['id' => $partido]) }}" class="list-group-item list-group-item-action border-2 rounded-4 overflow-hidden">
                        <div class="d-inline-flex align-items-center gap-3 bg-light border rounded-3 px-3 py-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-medium text-dark">{{ $local->Nombre }}</span>
                                <img src="{{ $local->url_logo }}" alt="Local" style="width: 1.5rem;">
                            </div>
                            
                            <span class="badge bg-dark px-3 py-2 fs-6 rounded-pill">
                                {{ $partido->Goles_Local }} - {{ $partido->Goles_Visitante }}
                            </span>
                            
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $visitante->url_logo }}" alt="Visitante" style="width: 1.5rem;">
                                <span class="fw-medium text-dark">{{ $visitante->Nombre }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12">
                    <hr class="text-muted my-1"> 
                </div>

                <div class="col-md-4">
                    <label class="text-muted fw-bold small mb-2">OJEADOR</label>
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <img src="{{ $ojeador?->pais?->Bandera }}" alt="Bandera" style="width: 1.5rem;" class="rounded-1">
                        <span class="text-dark fw-medium">
                            {{ $ojeador->Nombre }} {{ $ojeador->Apellido1 }}
                            @if($ojeador->Apodo) 
                                <span class="text-secondary">"{{ $ojeador->Apodo }}"</span> 
                            @endif
                        </span>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="text-muted fw-bold small mb-2 d-block">FECHA DEL INFORME</label>
                    <span class="badge bg-light text-secondary border px-3 py-2 fs-6 fw-normal">
                        {{ \Carbon\Carbon::parse($informe->Fecha_Informe)->format('d / m / Y') }}
                    </span>
                </div>

                <div class="col-md-4">
                    <label class="text-muted fw-bold small mb-2 d-block">POTENCIAL</label>
                    @php
                        $colorPotencial = match($informe->Potencial) {
                            'Generacional' => 'bg-dark text-white',
                            'Élite' => 'bg-primary text-white',
                            'Alto' => 'bg-success text-white',
                            'Medio' => 'bg-warning text-dark',
                            'Bajo' => 'bg-danger text-white',
                            'Estable' => 'bg-info text-dark',
                            'En Declive' => 'bg-secondary text-white',
                            'Últimos Años' => 'bg-light text-secondary border',
                            default => 'bg-secondary text-white',
                        };
                    @endphp
                    <span class="badge {{ $colorPotencial }} px-3 py-2 fs-6 mt-1">
                        {{ $informe->Potencial }}
                    </span>
                </div>

                <div class="col-12 mt-3">
                    <label class="text-uppercase text-muted fw-bold small mb-2 d-block">Observaciones Generales</label>
                    <div class="bg-light border border-light-subtle rounded-3 p-3 text-dark">
                        <p class="mb-0" style="line-height: 1.6;">{{ $informe->Valoraciones }}</p>
                    </div>
                </div>
                <a href="{{ route('informes.principal') }}" class="btn btn-primary text-white border">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Open Sans', system-ui, sans-serif;
    }
</style>
@endsection
