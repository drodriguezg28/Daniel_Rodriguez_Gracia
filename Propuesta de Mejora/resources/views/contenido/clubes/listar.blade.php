@extends('components.layouts.config_layout')
@section('title', 'Listado de Clubes')

@section('content')

@vite(['resources/css/listar.css'])


<div class="container mt-4 bg-white p-4 rounded ">
    
    @if(Auth::user()->tipo_usuario === 'admin')
        <a href="{{route('clubes.creacion')}}" class="btn btn-primary w-100 text-white"><i class="bi bi-plus-lg me-1"></i>Crear Club</a>
    @endif
    <br><br>
    <h2 class="mb-4">Listado de Clubes</h2>
    <div class="row">
        @forelse ($clubes as $club)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{$club->url_logo}}" alt="Logo de {{ $club->Nombre }}" style="width: 3em; height: 4em; object-fit: fill;">
                            &emsp;
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $club->Nombre }}</h6>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <img src="{{ $club?->pais?->Bandera }}" alt="Bandera {{ $club?->pais?->Nombre }}" class="me-1" style="width: 1.7em; border: 0.1em solid #eee;">
                            <small class="text-secondary">{{ $club?->pais?->Nombre }}</small>
                        </div>

                        @if (Auth::user()->tipo_usuario === 'admin')
                            <div class="dropdown">
                                <button class="btn btn-sm btn-custom-primary dropdown-toggle w-100 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear me-1"></i>Opciones
                                </button>
                                
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item text-dark" href="{{ route('clubes.ver', ['id' => $club->ID_Club]) }}"><i class="bi bi-eye me-2"></i>Ver Datos</a></li>
                                    <li><a class="dropdown-item text-dark" href="{{ route('clubes.editar', ['id' => $club->ID_Club]) }}"><i class="bi bi-pencil-square me-2"></i>Editar Datos</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('clubes.eliminar', ['id' => $club->ID_Club]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger fw-bold" 
                                                    onclick="return confirm('¿Estás seguro de eliminar este club?')">
                                                <i class="bi bi-trash me-2"></i>Eliminar Club
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="d-grid">
                                <a href="{{ route('clubes.ver', ['id' => $club->ID_Club]) }}" class="btn btn-sm btn-custom-primary">
                                    <i class="bi bi-eye me-2"></i> Ver Datos
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 w-100">
                <i class="bi bi-shield-x text-muted" style="font-size: 3.5rem; opacity:0.4;"></i>
                <h5 class="mt-3 text-secondary">No hay clubes registrados</h5>
                <p class="text-muted small">Añade el primer club usando el botón superior.</p>
            </div>
        @endforelse
    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-center">
            {{ $clubes->links() }}
        </div>
    </div>
</div>
@endsection
