@extends('components.layouts.config_layout')
@section('title', 'Crear Club')


@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4 bg-white p-4 rounded ">
    <h2 class="h4 mb-4 text-dark">Nuevo Club</h2>
    
    <form action="{{ route('clubes.crear') }}" method="POST">
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
                <label class="form-label fw-bold small text-secondary">Nombre</label>
                <input type="text" name="Nombre" value="{{ old('Nombre') }}" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Pais</label>
                <select name="Pais" class="form-select">
                    <option value="">Seleccione un país...</option>
                    @foreach ($paises as $pais)
                        <option value="{{$pais->ID_Pais}}" @selected(old('Pais') == $pais->ID_Pais)>
                            {{ $pais->Nombre }} ({{ $pais->Continente }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">URL del Escudo del Club</label>
                <div class="input-group">
                    <input type="text" name="url_logo" value="{{ old('url_logo') }}" class="form-control">
                    <button class="btn btn-outline-secondary" type="submit" name="cosa" value="vista_previa">Probar URL</button>
            </div>
            
            <div class="mt-3 text-center">
                @if(old('url_logo') || isset($club->Foto_Perfil))
                    <img src="{{ old('url_logo') }}" class="img-thumbnail" style="width: 3em; height: 4em; object-fit: fill;">
                @else
                    <div class="p-5 border border-dashed text-muted">Sin vista previa</div>
                @endif
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold small text-secondary">Usuario vinculado</label>
                <select name="Usuario" class="form-select">
                    <option value="">Seleccione un usuario...</option>
                    @forelse ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" @selected(old('Usuario') == $usuario->id)>
                            {{ $usuario->name }} ({{ $usuario->email }})
                        </option>
                    @empty
                        <option value="">No hay usuarios con rol club</option>
                    @endforelse
                </select>
            </div>
            
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" name="action" value="guardar" class="btn btn-primary px-4 ">
                Crear Club
            </button>
            <a href="{{ route('clubes.principal') }}" class="btn btn-secondary px-4">
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
