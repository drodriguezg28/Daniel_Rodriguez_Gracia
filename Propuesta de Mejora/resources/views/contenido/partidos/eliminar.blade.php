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
            @foreach ($partidos as $partido)
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
                            <div class="mb-3 flex-grow-1 text-center">
                                <small class="mb-0 text-dark">Fecha del Partido: {{ $partido->Fecha }}</small>
                            </div>

                            <div class="d-grid">
                            <form action="{{ route('partidos.eliminar', ['id' => $partido->ID_Partido_Cubierto]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                
                                <button type="submit" class="btn btn-sm btn-custom-primary w-100" 
                                        onclick="return confirm('¿Estás seguro de eliminar este Partido?')">
                                    <i class="bi bi-trash"></i> Eliminar Partido
                                </button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="container mt-4">
            <div class="d-flex justify-content-center">
                {{ $partidos->links() }}
            </div>
        </div>
    </div>
@endsection
