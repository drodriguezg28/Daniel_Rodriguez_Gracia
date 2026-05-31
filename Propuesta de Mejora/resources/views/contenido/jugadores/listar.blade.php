@extends('components.layouts.config_layout')
@section('title', 'Listado de Jugadores')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@vite(['resources/css/listar.css'])

@php 
    $PorDefecto = asset('img/player-fallback-dark.png'); 
@endphp

<div class="container mt-4 bg-white p-4 rounded ">
    
    @if(Auth::user()->tipo_usuario === 'admin')
        <a href="{{route('jugadores.creacion')}}" class="btn btn-primary w-100 text-white"><i class="bi bi-plus-lg me-1"></i>Crear Jugador</a>
    @endif
    <br><br>
    <h2 class="mb-4">Listado de Jugadores</h2>
    <div class="row">
        @forelse ($jugadores as $jugador)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                @if ( Auth::user()->id === $jugador->Usuario )
                    <div class="card h-100  border-primary border-2">
                @else
                    <div class="card h-100 ">
                @endif
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $jugador->Foto_Perfil }}" onerror="this.src='{{ $PorDefecto }}';" alt="{{ $jugador->Apodo }}" class="img-thumbnail rounded-circle me-3" style="width: 4em; height: 4em; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $jugador->Nombre }}</h6>
                                @if ($jugador->Apodo and $jugador->Apodo !== "-")
                                    <h6 class="mb-0 fw-bold">"{{ $jugador->Apodo }}"</h6>
                                @endif
                                <small class="text-muted">{{ $jugador->Apellido1 }} {{ $jugador->Apellido2 }}</small>
                            </div>
                        </div>
                        <div class="mb-2">
                            @if($jugador->club)
                                <img src="{{ $jugador?->club?->url_logo }}" alt="Logo Club" class="me-1" style="width: 20px;">
                                <small class="fw-bold">{{ $jugador?->club?->Nombre }}</small>
                            @endif
                        </div>

                        <div class="mb-3 d-flex">
                            @if($jugador->pais)
                                <img src="{{ $jugador?->pais?->Bandera }}" alt="Bandera" class="me-1" style="width: 25px;">
                                
                                <small class="text-secondary">{{ $jugador?->pais?->Nombre }}</small>
                            @endif
                        </div>

                        @if(Auth::user()->tipo_usuario === 'admin' or Auth::user()->id === $jugador->Usuario )
                            <div class="dropdown">
                                <button class="btn btn-sm btn-custom-primary dropdown-toggle w-100 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear me-1"></i>Opciones
                                </button>
                                
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item text-dark" href="{{ route('jugadores.ver', ['id' => $jugador->ID_Jugador]) }}"><i class="bi bi-eye me-2"></i>Ver Datos</a></li>
                                    <li><a class="dropdown-item text-dark" href="{{ route('jugadores.editar', ['id' => $jugador->ID_Jugador]) }}"><i class="bi bi-pencil-square me-2"></i>Editar Datos</a></li>
                                    @if(Auth::user()->tipo_usuario === 'admin')
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('jugadores.eliminar', ['id' => $jugador->ID_Jugador]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger fw-bold" 
                                                        onclick="return confirm('¿Estás seguro de eliminar este Jugador?')">
                                                    <i class="bi bi-trash me-2"></i>Eliminar Jugador
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @else
                            <div class="d-grid">
                                <a href="{{ route('jugadores.ver', ['id' => $jugador->ID_Jugador]) }}" class="btn btn-sm btn-custom-primary">
                                    <i class="bi bi-eye me-2"></i> Ver Datos
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 w-100">
                <i class="bi bi-person-badge text-muted" style="font-size: 3.5rem; opacity:0.4;"></i>
                <h5 class="mt-3 text-secondary">No hay jugadores registrados</h5>
                <p class="text-muted small">Añade el primer jugador usando el botón superior.</p>
            </div>
        @endforelse
    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-center">
            {{ $jugadores->links() }}
        </div>
    </div>
</div>
@endsection
