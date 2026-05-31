@extends('components.layouts.config_layout')
@section('title', 'Listado de Ojeadores')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@vite(['resources/css/listar.css'])

<div class="container mt-4 bg-white p-4 rounded ">
    @if(Auth::user()->tipo_usuario === 'admin')
        <a href="{{ route('ojeadores.creacion') }}" class="btn btn-primary w-100 text-white"><i class="bi bi-plus-lg me-1"></i>Crear Ojeador</a>
    @endif
    <br><br>
    <h2 class="mb-4">Listado de Ojeadores</h2>
    <div class="row">
        @forelse ($ojeadores as $ojeador)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                @if (Auth::user()->id === $ojeador->Usuario)
                    <div class="card h-100  border-primary border-2">
                @else
                    <div class="card h-100 ">
                @endif
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0 fw-bold">{{ $ojeador->Nombre }}
                                @if(!empty(trim($ojeador->Apodo ?? '')))
                                    "{{ $ojeador->Apodo }}"
                                @endif
                                </h6>
                            </div>
                            <small class="text-muted">{{ $ojeador->Apellido1 }} {{ $ojeador->Apellido2 }}</small>
                        </div>

                        <div class="mb-3">
                            <img src="{{ $ojeador?->pais?->Bandera ?? '' }}" alt="Bandera" class="me-1" style="width: 25px; border: 1px solid #eee;">
                            <small class="text-secondary">{{ $ojeador?->pais?->Nombre ?? '—' }}</small>
                        </div>

                        @if(Auth::user()->tipo_usuario === 'admin' or Auth::user()->id === $ojeador->Usuario)
                            <div class="dropdown">
                                <button class="btn btn-sm btn-custom-primary dropdown-toggle w-100 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear me-1"></i>Opciones
                                </button>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item text-dark" href="{{ route('ojeadores.ver', ['id' => $ojeador->ID_Ojeador]) }}"><i class="bi bi-eye me-2"></i>Ver Datos</a></li>
                                    <li><a class="dropdown-item text-dark" href="{{ route('ojeadores.editar', ['id' => $ojeador->ID_Ojeador]) }}"><i class="bi bi-pencil-square me-2"></i>Editar Datos</a></li>
                                    @if(Auth::user()->tipo_usuario === 'admin')
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('ojeadores.eliminar', ['id' => $ojeador->ID_Ojeador]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger fw-bold"
                                                        onclick="return confirm('¿Estás seguro de eliminar este ojeador?')">
                                                    <i class="bi bi-trash me-2"></i>Eliminar Ojeador
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @else
                            <div class="d-grid">
                                <a href="{{ route('ojeadores.ver', ['id' => $ojeador->ID_Ojeador]) }}" class="btn btn-sm btn-custom-primary">
                                    <i class="bi bi-eye me-2"></i> Ver Datos
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted text-center py-4">No hay ojeadores registrados.</p>
            </div>
        @endforelse
    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-center">
            {{ $ojeadores->links() }}
        </div>
    </div>
</div>
@endsection
