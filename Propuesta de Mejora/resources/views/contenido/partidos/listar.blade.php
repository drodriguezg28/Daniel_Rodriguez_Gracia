@extends('components.layouts.config_layout')
@section('title', 'Listado de Partidos')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/listar.css'])


    <div class="container mt-4 bg-white p-4 rounded ">
        <div class="d-flex mt-1 mb-3 me-3">
            <a href="{{ route('partidos.creacion') }}" class="btn btn-sm btn-primary col-6 me-3">Añadir Partido </a>
            <a href="{{ route('partidos.vista_eliminar') }}" class="btn btn-sm btn-danger col-6 ">Eliminar Partido</a>
        </div>
        <h2 class="mb-4">Partidos</h2>
        <div class="row">
            @forelse ($partidos as $partido)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 ">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3 align-items-center flex-grow-1 d-flex justify-content-between">
                                <img src="{{ $partido?->Local?->url_logo }}" alt="Logo {{$partido?->Local?->Nombre}}" style="width: 1.5em; height: 1.5em; object-fit: contain;" class="me-3">
                                <small class="mb-0 text-dark text-truncate">
                                    <strong>{{ $partido?->Local?->Nombre }}</strong> {{ $partido->Goles_Local }} vs {{ $partido->Goles_Visitante }} <strong>{{ $partido?->Visitante?->Nombre }}</strong> 
                                </small>
                                <img src="{{ $partido?->Visitante?->url_logo }}" alt="Logo {{$partido?->Visitante?->Nombre}}" style="width: 1.5em; height: 1.5em; object-fit: contain;" class="ms-3">
                            </div>
                            <div class="mb-2 flex-grow-1 text-center">
                                @if($partido->Ganador === 'Local')
                                <span class="badge rounded-pill bg-primary-subtle text-primary mb-2">
                                        <i class="bi bi-trophy-fill me-1"></i> {{ $partido?->Local?->Nombre }}
                                    </span>
                                @elseif($partido->Ganador === 'Visitante')
                                    <span class="badge rounded-pill bg-danger-subtle text-danger mb-2">
                                        <i class="bi bi-trophy-fill me-1"></i> {{ $partido?->Visitante?->Nombre }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary-subtle text-secondary mb-2">
                                        <i class="bi bi-dash-circle me-1"></i> Empate
                                    </span>
                                @endif
                                <br><small class="mb-0 text-dark">Fecha: {{ $partido->Fecha }}</small>
                            </div>

                            <div class="d-grid">
                                <a href="{{ route('partidos.ver', ['id' => $partido->ID_Partido_Cubierto]) }}" class="btn btn-sm btn-custom-primary">
                                    <i class="bi bi-eye"></i> Ver Partido
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 w-100">
                    <i class="bi bi-calendar-x text-muted" style="font-size: 3.5rem; opacity:0.4;"></i>
                    <h5 class="mt-3 text-secondary">No hay partidos registrados</h5>
                    <p class="text-muted small">Añade el primer partido usando el botón superior.</p>
                </div>
            @endforelse
        </div>
        <div class="container mt-4">
            <div class="d-flex justify-content-center">
                {{ $partidos->links() }}
            </div>
        </div>
    </div>
@endsection
