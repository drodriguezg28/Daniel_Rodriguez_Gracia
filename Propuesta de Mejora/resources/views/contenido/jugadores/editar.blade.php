@extends('components.layouts.config_layout')
@section('title', 'Editar Jugador')

@php
    $posiciones = [
        'Portero', 'Defensa Central', 'Lateral Derecho', 'Lateral Izquierdo', 'Carrilero', 
        'Pivote', 'Mediocentro', 'Mediapunta', 'Interior Derecho', 'Interior Izquierdo', 
        'Extremo Derecho', 'Extremo Izquierdo', 'Segundo Delantero', 'Delantero Centro'
    ];
@endphp

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded ">
    <h2 class="h4 mb-4 text-dark">Editar Perfil de {{ $jugador->Nombre }} {{ $jugador->Apellido1 }} {{ $jugador->Apellido2 }}</h2>

    @php $jugador->Fecha_Nacimiento = \Carbon\Carbon::parse($jugador->Fecha_Nacimiento)->format('Y-m-d'); @endphp
    
    <form action="{{ route('jugadores.actualizar', ['id' => $jugador->ID_Jugador]) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3">
            
            <div class="col-md-6">
                <div>
                    <label class="form-label fw-bold small text-secondary">Foto de Perfil (URL)</label>
                    <div class="input-group">
                        <input type="text" name="Foto_Perfil" value="{{ old('Foto_Perfil', $jugador->Foto_Perfil) }}" class="form-control">
                        <button class="btn btn-outline-secondary" type="submit" name="cosa" value="vista_previa">Probar URL</button>
                    </div>    
                </div>
            
                <div class="mt-3 text-center">
                    @if(old('Foto_Perfil') || $jugador->Foto_Perfil)
                        <img src="{{ old('Foto_Perfil', $jugador->Foto_Perfil) }}" class="img-thumbnail" style="width: 3em; height: 4em; object-fit: fill;" alt="Vista previa">
                    @else
                        <div class="p-5 border border-dashed text-muted">Sin vista previa</div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <!-- Espacio vacío intencional para cuadrar la cuadrícula visualmente, tal como lo tenías -->
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Nombre</label>
                <input type="text" name="Nombre" value="{{ old('Nombre', $jugador->Nombre) }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Primer Apellido</label>
                <input type="text" name="Apellido1" value="{{ old('Apellido1', $jugador->Apellido1) }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Segundo Apellido</label>
                <input type="text" name="Apellido2" value="{{ old('Apellido2', $jugador->Apellido2) }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Apodo</label>
                <input type="text" name="Apodo" value="{{ old('Apodo', $jugador->Apodo) }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Fecha de Nacimiento</label>
                <input type="date" name="Fecha_Nacimiento" value="{{ old('Fecha_Nacimiento', $jugador->Fecha_Nacimiento) }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Nacionalidad</label>
                <select name="Nacionalidad" class="form-select">
                    <option value="">Seleccione un país...</option>
                    @foreach ($paises as $pais)
                        <option value="{{ $pais->ID_Pais }}" {{ old('Nacionalidad', $jugador->Nacionalidad) == $pais->ID_Pais ? 'selected' : '' }}>
                            {{ $pais->Nombre }} ({{ $pais->Continente }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Altura</label>
                <div class="input-group">
                    <input type="number" name="Altura" step="1" value="{{ old('Altura', $jugador->Altura) }}" class="form-control">
                    <span class="input-group-text">cm</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Peso</label>
                <div class="input-group">
                    <input type="number" name="Peso" step="0.1" value="{{ old('Peso', $jugador->Peso) }}" class="form-control">
                    <span class="input-group-text">kg</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Posición Principal</label>
                <select name="Posicion_Principal" class="form-select">
                    <option value="">Ninguna</option>
                    @foreach($posiciones as $posicion)
                        <option value="{{ $posicion }}" {{ old('Posicion_Principal', $jugador->Posicion_Principal) == $posicion ? 'selected' : '' }}>
                            {{ $posicion }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Posición Secundaria</label>
                <select name="Posicion_Secundaria" class="form-select">
                    <option value="">Ninguna</option>
                    @foreach($posiciones as $posicion)
                        <option value="{{ $posicion }}" {{ old('Posicion_Secundaria', $jugador->Posicion_Secundaria) == $posicion ? 'selected' : '' }}>
                            {{ $posicion }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Valor de Mercado</label>
                <div class="input-group">
                    <input type="number" name="Valor_Mercado" step="1" value="{{ old('Valor_Mercado', $jugador->Valor_Mercado) }}" class="form-control">
                    <span class="input-group-text">€</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Dorsal</label>
                <select name="Dorsal" class="form-select">
                    <option value="">Seleccione un Dorsal ...</option>
                    @for ($i = 1; $i <= 99; $i++)
                        <option value="{{ $i }}" {{ old('Dorsal', $jugador->Dorsal_actual) == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Club Actual</label>
                <select name="Club_Actual" class="form-select">
                    <option value="">Sin equipo</option>
                    @foreach ($clubes as $club)
                        <option value="{{ $club->ID_Club }}" {{ old('Club_Actual', $jugador->Club_Actual) == $club->ID_Club ? 'selected' : '' }}>
                            {{ $club->Nombre }} ({{ $club?->pais?->Nombre ?? 'Sin país' }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Agente</label>
                <select name="Agente" class="form-select">
                    <option value="">Sin agente</option>
                    @foreach ($agentes as $agente)
                        <option value="{{ $agente->ID_Agente }}" {{ old('Agente', $jugador->Agente) == $agente->ID_Agente ? 'selected' : '' }}>
                            {{ trim($agente->Nombre . ' ' . $agente->Apellido1 . ' ' . $agente->Apellido2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Usuario vinculado</label>
                <select name="Usuario" class="form-select">
                    <option value="">Sin usuario vinculado</option>
                    @forelse ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" @selected(old('Usuario', $jugador->Usuario) == $usuario->id)>
                            {{ $usuario->name }} ({{ $usuario->email }})
                        </option>
                    @empty
                        <option value="">No hay usuarios disponibles</option>
                    @endforelse
                </select>
            </div>
        
        </div>
        
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4 ">
                Actualizar Datos
            </button>
            <a href="{{ route('jugadores.principal') }}" class="btn btn-secondary px-4">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </form>
</div>

<style>
    body {
        background-color: #f4f7f6;
        font-family: 'Open Sans', sans-serif;
    }
    .form-control, .form-select, .input-group-text {
        height: 42px;
    }
    .nav-link { color: #cbd5e1; }
</style>
@endsection
