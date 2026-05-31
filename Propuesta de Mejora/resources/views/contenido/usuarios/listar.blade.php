@extends('components.layouts.config_layout')

@vite(['resources/css/listar.css'])
@section('title', 'Listado de Usuarios')



@section('content')

<div class="container mt-4 bg-white p-4 rounded ">

    
    <a href="{{route('usuarios.creacion')}}" class="btn btn-primary w-100 text-white"><i class="bi bi-plus-lg me-1"></i>Crear usuario</a>
    <br><br>
    <h2 class="mb-4">Listado de usuarios</h2>
        <div class="row">
        @forelse ($usuarios as $usuario)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
            @if ( Auth::user()->id === $usuario->id )
                <div class="card h-100  border-primary border-2">
            @else
                <div class="card h-100 ">
            @endif
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $usuario->name }}</h6>
                                <small class="text-muted">{{ $usuario->email }}</small>
                                <br>
                                @php
                                    $badgeClass = match($usuario->tipo_usuario) {
                                        'admin'   => 'bg-danger-subtle text-danger',
                                        'ojeador' => 'bg-primary-subtle text-primary',
                                        'agente'  => 'bg-success-subtle text-success',
                                        default   => 'bg-secondary-subtle text-secondary',
                                    };
                                @endphp
                                <span class="badge rounded-pill {{ $badgeClass }} mt-1">{{ $usuario->tipo_usuario }}</span>
                            </div>
                        </div>

                    
                        <div class="dropdown">
                            <button class="btn btn-sm btn-custom-primary dropdown-toggle w-100 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear me-1"></i>Opciones
                            </button>
                            
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-dark" href="{{ route('usuarios.ver', ['id' => $usuario->id]) }}"><i class="bi bi-eye me-2"></i>Ver Datos</a></li>
                                <li><a class="dropdown-item text-dark" href="{{ route('usuarios.editar', ['id' => $usuario->id]) }}"><i class="bi bi-pencil-square me-2"></i>Editar Datos</a></li>
                                
                                @if(Auth::user()->tipo_usuario === 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('usuarios.eliminar', ['id' => $usuario->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger fw-bold" 
                                                    onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                <i class="bi bi-trash me-2"></i>Eliminar usuario
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 w-100">
                <i class="bi bi-people text-muted" style="font-size: 3.5rem; opacity:0.4;"></i>
                <h5 class="mt-3 text-secondary">No hay usuarios registrados</h5>
                <p class="text-muted small">Crea el primer usuario usando el botón superior.</p>
            </div>
        @endforelse
    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-center">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>
@endsection
