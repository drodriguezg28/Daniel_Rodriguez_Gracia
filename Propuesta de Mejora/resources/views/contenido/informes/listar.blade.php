@extends('components.layouts.config_layout')
@section('title', 'Listado de Informes')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@vite(['resources/css/listar.css'])

<div class="container mt-4 bg-white p-4 rounded ">
    @if(Auth::user()->tipo_usuario === 'admin' or Auth::user()->tipo_usuario === 'ojeador')
        <a href="{{route('informes.creacion')}}" class="btn btn-primary w-100 text-white"><i class="bi bi-plus-lg me-1"></i>Crear Informe</a>
    @endif
    <br><br>
    <div class="container mt-4">
        <h3 class="mb-3">Informes Creados</h3>
        <div class="list-group">
            @forelse ($informes as $informe)
                @php 
                    $mostrar = false;
                    if(Auth::user()->tipo_usuario === 'admin') {
                        $mostrar = true;
                    } elseif(Auth::user()->tipo_usuario === 'ojeador' && $informe?->ojeador?->Usuario == Auth::user()->id) {
                        $mostrar = true;
                    }
                @endphp
                @if($mostrar)
                    @php
                        $partido=$informe->partido;
                        $jugador=$informe->jugador; 
                    @endphp
                    <a href="{{ route('informes.ver', ['id' => $informe->ID_Informe]) }}" class="list-group-item list-group-item-action p-0 mb-4 border-2 rounded-4 overflow-hidden">
                        <div class="d-flex align-items-center p-3 overflow-hidden bg-white">
                            
                            <div class="col-4 border-end pe-3">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <img src="{{ $partido?->Local?->url_logo }}" class="img-fluid" style="height: 35px; width: 35px; object-fit: contain;">
                                    <div class="mx-3 text-center">
                                        <span class="fs-4 fw-bold text-dark">{{ $partido->Goles_Local }}</span>
                                        <span class="mx-1 text-muted small">vs</span>
                                        <span class="fs-4 fw-bold text-dark">{{ $partido->Goles_Visitante }}</span>
                                    </div>
                                    <img src="{{ $partido?->Visitante?->url_logo }}" class="img-fluid" style="height: 35px; width: 35px; object-fit: contain;">
                                </div>
                                <div class="text-center">
                                    <p class="mb-0 small fw-bold text-uppercase text-truncate">{{ $partido?->Local?->Nombre }} - {{ $partido?->Visitante?->Nombre }}</p>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($informe->Fecha_Informe)->format('d/m/Y') }}
                                        <br>
                                        <i class="bi bi-geo-alt me-1"></i> {{ $partido->Localidad }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-8 ps-4 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative">
                                        <img src="{{ $jugador->Foto_Perfil }}" class="rounded-circle border border-2 border-primary p-1" style="width: 3.5em; height: 3.5em;">
                                        <img src="{{ $jugador?->pais?->Bandera }}" class="position-absolute bottom-0 end-0 border rounded-circle" style="width: 1.2em; height: 1.2em;">
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0 fw-bold text-primary">{{ $jugador->Nombre }} {{ $jugador->Apellido1 }}</h5>
                                        <div class="d-flex align-items-center mt-1">
                                            <img src="{{ $jugador?->Club?->url_logo }}" style="width: 18px; height: 18px; object-fit: contain;" class="me-1">
                                            <span class="text-muted small">{{ $jugador?->Club?->Nombre }}</span>
                                            <span class="mx-2 text-light">|</span>
                                            <span class="badge text-dark border">{{ $jugador->Posicion_Principal }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pe-3">
                                    <i class="bi bi-chevron-right text-muted fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            @empty
                <p class="text-muted text-center py-4">No hay informes disponibles.</p>
            @endforelse
        </div>
    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-center">
            {{ $informes->links() }}
        </div>
    </div>
</div>
@endsection
