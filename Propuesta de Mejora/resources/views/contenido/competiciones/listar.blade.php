@extends('components.layouts.config_layout')
@section('title', 'Listado de Competiciones')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@vite(['resources/css/listar.css'])

<div class="container mt-4 bg-white p-4 rounded">

    @if(Auth::user()->tipo_usuario === 'admin')
        <a href="{{ route('competiciones.creacion') }}" class="btn btn-primary w-100 text-white">
            <i class="bi bi-plus-lg me-1"></i>Crear Competición
        </a>
    @endif
    <br><br>
    <h2 class="mb-4">Listado de Competiciones</h2>

    <div class="row">
        @forelse ($competiciones as $competicion)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                                 style="width: 3em; height: 3em; min-width: 3em;">
                                <i class="bi bi-trophy text-white fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $competicion->Nombre }}</h6>
                                <small class="text-muted">{{ $competicion->Tipo }}</small>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            @if($competicion->pais)
                                <img src="{{ $competicion?->pais?->Bandera }}" alt="Bandera {{ $competicion?->pais?->Nombre }}"
                                     class="me-1" style="width: 1.7em; border: 0.1em solid #eee;">
                                <small class="text-secondary">{{ $competicion?->pais?->Nombre }}</small>
                            @else
                                <small class="text-muted fst-italic">Sin país asociado</small>
                            @endif
                        </div>

                        @if(Auth::user()->tipo_usuario === 'admin')
                            <div class="dropdown">
                                <button class="btn btn-sm btn-custom-primary dropdown-toggle w-100 d-flex align-items-center justify-content-center"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear me-1"></i>Opciones
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item text-dark"
                                           href="{{ route('competiciones.ver', ['id' => $competicion->ID_Competicion]) }}">
                                            <i class="bi bi-eye me-2"></i>Ver Datos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-dark"
                                           href="{{ route('competiciones.editar', ['id' => $competicion->ID_Competicion]) }}">
                                            <i class="bi bi-pencil-square me-2"></i>Editar Datos
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('competiciones.eliminar', ['id' => $competicion->ID_Competicion]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger fw-bold"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta competición?')">
                                                <i class="bi bi-trash me-2"></i>Eliminar Competición
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="d-grid">
                                <a href="{{ route('competiciones.ver', ['id' => $competicion->ID_Competicion]) }}"
                                   class="btn btn-sm btn-custom-primary">
                                    <i class="bi bi-eye me-2"></i>Ver Datos
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 w-100">
                <i class="bi bi-trophy text-muted" style="font-size: 3.5rem; opacity:0.4;"></i>
                <h5 class="mt-3 text-secondary">No hay competiciones registradas</h5>
                <p class="text-muted small">Añade la primera competición usando el botón superior.</p>
            </div>
        @endforelse
    </div>

    <div class="container mt-4">
        <div class="d-flex justify-content-center">
            {{ $competiciones->links() }}
        </div>
    </div>
</div>
@endsection
