@extends('components.layouts.config_layout')

@vite(['resources/css/listar.css'])

@section('title', 'Listado de Agentes')

@section('content')

<div class="container mt-4 bg-white p-4 rounded ">

    @if(Auth::user()->tipo_usuario === 'admin')
        <a href="{{route('agentes.creacion')}}" class="btn btn-primary w-100 text-white"><i class="bi bi-plus-lg me-1"></i>Crear Agente</a>
    @endif
    <br><br>
    <h2 class="mb-4">Listado de Agentes</h2>
    <div class="row">
        @forelse ($agentes as $agente)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                @if ( Auth::user()->id === $agente->Usuario )
                    <div class="card h-100  border-primary border-2">
                @else
                    <div class="card h-100 ">
                @endif
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $agente->Nombre }}</h6>
                                <small class="text-muted">{{ $agente->Apellido1 }} {{ $agente->Apellido2 }}</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <img src="{{ $agente->pais->Bandera }}" alt="Bandera" class="me-1" style="width: 25px; border: 1px solid #eee;">
                            <small class="text-secondary">{{ $agente->pais->Nombre }}</small>
                        </div>

                        @if(Auth::user()->tipo_usuario === 'admin' or Auth::user()->id === $agente->Usuario )
                            <div class="dropdown">
                                <button class="btn btn-sm btn-custom-primary dropdown-toggle w-100 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear me-1"></i>Opciones
                                </button>
                                
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item text-dark" href="{{ route('agentes.ver', ['id' => $agente->ID_Agente]) }}"><i class="bi bi-eye me-2"></i>Ver Datos</a></li>
                                    <li><a class="dropdown-item text-dark" href="{{ route('agentes.editar', ['id' => $agente->ID_Agente]) }}"><i class="bi bi-pencil-square me-2"></i>Editar Datos</a></li>
                                    @if(Auth::user()->tipo_usuario === 'admin')
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('agentes.eliminar', ['id' => $agente->ID_Agente]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger fw-bold" 
                                                        onclick="return confirm('¿Estás seguro de eliminar este agente?')">
                                                    <i class="bi bi-trash me-2"></i>Eliminar Agente
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @else
                            <div class="d-grid">
                                <a href="{{ route('agentes.ver', ['id' => $agente->ID_Agente]) }}" class="btn btn-sm btn-custom-primary">
                                    <i class="bi bi-eye me-2"></i> Ver Datos
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 w-100">
                <i class="bi bi-person-x text-muted" style="font-size: 3.5rem; opacity:0.4;"></i>
                <h5 class="mt-3 text-secondary">No hay agentes registrados</h5>
                <p class="text-muted small">Añade el primer agente usando el botón superior.</p>
            </div>
        @endforelse
    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-center">
            {{ $agentes->links() }}
        </div>
    </div>
</div>
@endsection
