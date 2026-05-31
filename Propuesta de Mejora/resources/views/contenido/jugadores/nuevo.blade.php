@extends('components.layouts.config_layout')
@section('title', 'Crear Jugador')

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
    
    <form action="{{ route('jugadores.crear') }}" method="POST">
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
        
        <div class="row g-3 w-100">
            <div class="col-md-6">
                <div>
                    <label class="form-label fw-bold small text-secondary">URL Foto de perfil</label>
                    <div class="input-group">
                        <input type="text" name="Foto_Perfil" value="{{ old('Foto_Perfil') }}" class="form-control">
                        <button class="btn btn-outline-secondary" type="submit" name="cosa" value="vista_previa">Probar URL</button>
                    </div>
                </div>
                
                <div class="mt-3 text-center">
                    @if(old('Foto_Perfil') || isset($club->Foto_Perfil))
                        <img src="{{ old('Foto_Perfil') }}" class="img-thumbnail" style="width: 3em; height: 4em; object-fit: fill;">
                    @else
                        <div class="p-5 border border-dashed text-muted">Sin vista previa</div>
                    @endif
                </div>
            </div>
            <div class="col-md-6"></div>

            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Nombre</label>
                <input type="text" name="Nombre" value="{{ old('Nombre') }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Primer Apellido</label>
                <input type="text" name="Apellido1" value="{{ old('Apellido1') }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Segundo Apellido</label>
                <input type="text" name="Apellido2" value="{{ old('Apellido2') }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Apodo</label>
                <input type="text" name="Apodo" value="{{ old('Apodo') }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Fecha de Nacimiento</label>
                <input type="date" name="Fecha_Nacimiento" value="{{ old('Fecha_Nacimiento') }}" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Nacionalidad</label>
                <select name="Nacionalidad" class="form-select">
                    <option value="">Seleccione un país...</option>
                    @foreach ($paises as $pais)
                        <option value="{{ $pais->ID_Pais }}" {{ old('Nacionalidad') == $pais->ID_Pais ? 'selected' : '' }}>
                            <img src="{{$pais->Bandera}}  ?? ' '" alt="escudo"> {{ $pais->Nombre }} ({{ $pais->Continente }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Altura</label>
                <div class="input-group">
                    <input type="number" name="Altura" step="1" value="{{ old('Altura') }}" class="form-control">
                    <span class="input-group-text">cm</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Peso</label>
                <div class="input-group">
                    <input type="number" name="Peso" step="0.1" value="{{ old('Peso') }}" class="form-control">
                    <span class="input-group-text">kg</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Posición Principal</label>
                <select name="Posicion_Principal" class="form-select">
                    <option value="">Seleccione una posición...</option>
                    @foreach($posiciones as $posicion)
                    <option value="{{ $posicion }}" {{ old('Posicion_Principal') == $posicion ? 'selected' : '' }}>
                        {{ $posicion }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Posición Secundaria</label>
                <select name="Posicion_Secundaria" class="form-select">
                    <option value="">Seleccione una posición...</option>
                    <option value="Ninguna">Ninguna</option>
                    @foreach($posiciones as $posicion)
                    <option value="{{ $posicion }}" {{ old('Posicion_Secundaria') == $posicion ? 'selected' : '' }}>
                        {{ $posicion }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Valor de Mercado</label>
                <div class="input-group">
                    <input type="number" name="Valor" step="1" value="{{ old('Valor')}}" class="form-control">
                    <span class="input-group-text">M€</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Dorsal</label>
                <select name="Dorsal" class="form-select">
                    <option value="">Seleccione un Dorsal ...</option>
                    @for ($i = 1; $i < 100; $i++)
                        <option value="{{ $i }}" {{ old('Dorsal') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Club</label>
                <select name="Club" class="form-select">
                    <option value="">Seleccione un club...</option>
                    @foreach ($clubes as $club)
                    <option value="{{ $club->ID_Club }}" {{ old('Club') == $club->ID_Club ? 'selected' : '' }}>
                        {{ $club->Nombre }} ({{ $club?->pais?->Nombre }})
                    </option>
                    @endforeach
                </select>
            </div>


            

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Agente</label>
                <select name="Agente" class="form-select">
                    <option value="">Seleccione un agente...</option>
                    @foreach ($agentes as $agente)
                    <option value="{{ $agente->ID_Agente }}" {{ old('Agente')  == $agente->ID_Agente ? 'selected' : '' }}>
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
                        <option value="{{ $usuario->id }}" @selected(old('Usuario') == $usuario->id)>
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
                Crear Jugador
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
