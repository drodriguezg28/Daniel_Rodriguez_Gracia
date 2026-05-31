@extends('components.layouts.config_layout')
@section('title', 'Mi Perfil')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h3 class="fw-bold mb-0"><i class="bi bi-person-circle me-2 text-primary"></i>Mi Perfil</h3>
        <p class="text-muted small mb-0">Actualiza tus datos personales y de acceso</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Volver
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Hay errores en el formulario:</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('jugador.perfil.actualizar') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">

        {{-- Columna izquierda: Foto + datos básicos de solo lectura --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 rounded-3">
                @if($jugador->Foto_Perfil)
                    <img src="{{ $jugador->Foto_Perfil }}"
                         onerror="this.src='{{ asset('img/player-fallback-dark.png') }}';"
                         alt="{{ $jugador->Nombre }}"
                         class="rounded-circle mx-auto mb-3 border border-3 border-primary"
                         style="width:110px; height:110px; object-fit:cover;">
                @else
                    <div class="rounded-circle bg-primary bg-opacity-10 mx-auto mb-3 d-flex align-items-center justify-content-center"
                         style="width:110px; height:110px;">
                        <i class="bi bi-person-fill text-primary fs-1"></i>
                    </div>
                @endif
                <h5 class="fw-bold">{{ $jugador->Nombre }} {{ $jugador->Apellido1 }}</h5>
                @if($jugador->Apodo && trim($jugador->Apodo) !== '-')
                    <p class="text-muted mb-1">"{{ $jugador->Apodo }}"</p>
                @endif
                @if($jugador->club)
                    <div class="d-flex align-items-center justify-content-center gap-1 mt-1">
                        <img src="{{ $jugador->club->url_logo }}" style="width:1.4em; height:1.4em; object-fit:contain;">
                        <span class="small text-muted">{{ $jugador->club->Nombre }}</span>
                    </div>
                @endif
                <hr>
                <div class="text-start">
                    <div class="mb-2">
                        <span class="small text-muted fw-semibold text-uppercase">Posición</span>
                        <p class="mb-0">{{ $jugador->Posicion_Principal ?? '—' }}</p>
                    </div>
                    @if($jugador->Dorsal_actual)
                    <div class="mb-2">
                        <span class="small text-muted fw-semibold text-uppercase">Dorsal</span>
                        <p class="mb-0">#{{ $jugador->Dorsal_actual }}</p>
                    </div>
                    @endif
                    @if($jugador->pais)
                    <div>
                        <span class="small text-muted fw-semibold text-uppercase">Nacionalidad</span>
                        <div class="d-flex align-items-center gap-1 mt-1">
                            <img src="{{ asset($jugador->pais->Bandera) }}" style="width:1.4em;">
                            <span class="small">{{ $jugador->pais->Nombre }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Columna derecha: formulario editable --}}
        <div class="col-md-8">

            {{-- Datos personales --}}
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-person me-2 text-primary"></i>Datos Personales</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="Nombre" class="form-control @error('Nombre') is-invalid @enderror"
                                   value="{{ old('Nombre', $jugador->Nombre) }}" required maxlength="30">
                            @error('Nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Primer Apellido <span class="text-danger">*</span></label>
                            <input type="text" name="Apellido1" class="form-control @error('Apellido1') is-invalid @enderror"
                                   value="{{ old('Apellido1', $jugador->Apellido1) }}" required maxlength="30">
                            @error('Apellido1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Segundo Apellido</label>
                            <input type="text" name="Apellido2" class="form-control @error('Apellido2') is-invalid @enderror"
                                   value="{{ old('Apellido2', $jugador->Apellido2) }}" maxlength="30">
                            @error('Apellido2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Apodo</label>
                            <input type="text" name="Apodo" class="form-control @error('Apodo') is-invalid @enderror"
                                   value="{{ old('Apodo', $jugador->Apodo) }}" maxlength="30">
                            @error('Apodo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Altura (cm)</label>
                            <input type="number" name="Altura" class="form-control @error('Altura') is-invalid @enderror"
                                   value="{{ old('Altura', $jugador->Altura ? $jugador->Altura * 100 : '') }}"
                                   min="0" max="250">
                            @error('Altura') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Peso (kg)</label>
                            <input type="number" step="0.01" name="Peso" class="form-control @error('Peso') is-invalid @enderror"
                                   value="{{ old('Peso', $jugador->Peso) }}" min="0" max="200">
                            @error('Peso') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Datos de acceso --}}
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-lock me-2 text-primary"></i>Datos de Acceso</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small text-secondary">Correo electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Dejar vacío para no cambiar" minlength="8">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Repite la nueva contraseña">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-end gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-floppy me-1"></i> Guardar cambios
                </button>
            </div>

        </div>
    </div>
</form>

@endsection
