@extends('components.layouts.config_layout')
@section('title', 'Ver Jugador')

@php
    $posiciones = [
        'Portero', 'Defensa Central', 'Lateral Derecho', 'Lateral Izquierdo', 'Carrilero', 
        'Pivote', 'Mediocentro', 'Mediapunta', 'Interior Derecho', 'Interior Izquierdo', 
        'Extremo Derecho', 'Extremo Izquierdo', 'Segundo Delantero', 'Delantero Centro'
    ];
     
    $PorDefecto = asset('img/player-fallback-dark.png');
@endphp

@section('content')

<div class="mt-4 bg-white p-4 rounded-3 shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-3 mb-4 gap-2">
        <h2 class="h4 mb-0 text-dark">Editar Perfil de {{$jugador->Nombre}} {{ $jugador->Apellido1 }} {{ $jugador->Apellido2 }}</h2>
        @if (Auth::user()->tipo_usuario === 'admin' or Auth::user()->id === $informe?->ojeador?->Usuario )
            <a href="{{ route('jugadores.editar', ['id' => $jugador->ID_Jugador]) }}" class="btn btn-primary btn-sm">Editar Datos</a>
        @endif
    </div>

    <div class="mb-4 text-center text-md-start">
        <img src="{{ $jugador->Foto_Perfil }}" onerror="this.src='{{ $PorDefecto }}';" alt="{{ $jugador->Apodo }}" class="img-thumbnail rounded-circle shadow-sm" style="width: 150px; height:150px; object-fit:cover;">
    </div>

    <div class="row g-3">
        
        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Nombre</label>
            <p class="mb-0">{{ $jugador->Nombre }}</p>
        </div>
        
        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Primer Apellido</label>
            <p class="mb-0">{{ $jugador->Apellido1 }}</p>
        </div>
        
        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Segundo Apellido</label>
            <p class="mb-0">{{ $jugador->Apellido2 }}</p>
        </div>
        
        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Apodo</label>
            <p class="mb-0">{{ $jugador->Apodo }}</p>
        </div>
        
        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Fecha de Nacimiento</label>
            <p class="mb-0">{{ \Carbon\Carbon::parse($jugador->Fecha_Nacimiento)->format('d-m-Y') }}</p>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Nacionalidad</label>
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset($jugador?->pais?->Bandera) }}" alt="" style="width:1.5em;">
                <span class="small"> {{ $jugador?->pais?->Nombre ?? 'Sin Asignar' }} ({{ $jugador?->pais?->Continente }})</span>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Altura</label>
            <p class="mb-0">{{ $jugador->Altura }} cm</p>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Peso</label>
            <p class="mb-0">{{$jugador->Peso}} kg</p>
        </div>
        
        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Posición Principal</label>
            <p class="mb-0">{{$jugador->Posicion_Principal}}</p>
        </div>
        
        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Posición Secundaria</label>
            <p class="mb-0">{{$jugador->Posicion_Secundaria}}</p>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Valor de Mercado</label>
            <p class="mb-0">{{ number_format($jugador->Valor_Mercado, 0, ',', '.') }} &euro;</p>
        </div>
        
        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Agente</label>
            <p class="mb-0">{{$jugador?->agente?->Nombre . ' ' . $jugador?->agente?->Apellido1}}</p>
        </div>
        
        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Dorsal</label>
            <p class="mb-0">{{$jugador->Dorsal_actual}}</p>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Club</label>
            <div class="d-flex align-items-center gap-1">
                <img src="{{ $jugador?->club?->url_logo }}" alt="Logo" style="width:1.5em;">
                <span class="small"> {{ $jugador?->club?->Nombre }}</span>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-3">
            <label class="form-label fw-bold small text-secondary mb-1">Usuario vinculado</label>
            @if($jugador->Usuario)
                <p class="mb-0 small text-truncate" title="{{ $jugador?->Usuario?->email }}">{{ $jugador?->Usuario?->name }}</p>
            @else
                <p class="mb-0 text-muted small">Sin usuario vinculado</p>
            @endif
        </div>

    </div>

    <hr class="text-muted my-4"> 

    {{-- ======================= ESTADÍSTICAS HISTÓRICAS ======================= --}}
    <div class="mt-2">
        <h4 class="h5 fw-bold mb-3">
            <i class="bi bi-bar-chart-line me-2 text-primary"></i>Estadísticas Históricas
        </h4>

        @if($jugador->estadisticas->count() > 0)
            @php
                // Agrupar estadísticas por temporada
                $estadisticasPorTemporada = $jugador->estadisticas->sortByDesc(function($e) {
                    return $e->temporada?->Nombre_Temporada ?? '';
                })->groupBy(function($e) {
                    return $e->temporada?->Nombre_Temporada ?? 'Sin temporada';
                });

                // Total
                $totalPartidos = $jugador->estadisticas->sum('Partidos_jugados');
                $totalGoles = $jugador->estadisticas->sum('Goles');
                $totalAsistencias = $jugador->estadisticas->sum('Asistencias');
                $totalAmarillass  = $jugador->estadisticas->sum('Tarjetas_amarillas');
                $totalRojas = $jugador->estadisticas->sum('Tarjetas_rojas');
            @endphp

            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Temporada</th>
                            <th>Competición</th>
                            <th>Club</th>
                            <th class="text-center"><i class="bi bi-controller" title="Partidos jugados"></i> PJ</th>
                            <th class="text-center"><i class="bi bi-bullseye" title="Goles"></i> G</th>
                            <th class="text-center"><i class="bi bi-arrow-right-circle" title="Asistencias"></i> A</th>
                            <th class="text-center"><span class="badge bg-warning text-dark px-1">TA</span></th>
                            <th class="text-center"><span class="badge bg-danger px-1">TR</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estadisticasPorTemporada as $temporadaNombre => $statsTemporada)
                            @foreach($statsTemporada as $stat)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $statsTemporada->count() }}" class="fw-bold text-primary align-middle border-start border-3 border-primary ps-2">
                                            {{ $temporadaNombre }}
                                        </td>
                                    @endif
                                    <td>{{ $stat->competicion?->Nombre ?? '—' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            @if($stat->club?->url_logo)
                                                <img src="{{ $stat->club->url_logo }}" alt="{{ $stat->club->Nombre }}"
                                                     style="width:1.3em; height:1.3em; object-fit:contain;">
                                            @endif
                                            <small>{{ $stat->club?->Nombre ?? '—' }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $stat->Partidos_jugados }}</td>
                                    <td class="text-center fw-bold">{{ $stat->Goles }}</td>
                                    <td class="text-center">{{ $stat->Asistencias }}</td>
                                    <td class="text-center">
                                        @if($stat->Tarjetas_amarillas > 0)
                                            <span class="badge bg-warning text-dark">{{ $stat->Tarjetas_amarillas }}</span>
                                        @else
                                            <span class="text-muted">0</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($stat->Tarjetas_rojas > 0)
                                            <span class="badge bg-danger">{{ $stat->Tarjetas_rojas }}</span>
                                        @else
                                            <span class="text-muted">0</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="3">TOTALES CARRERA</td>
                            <td class="text-center">{{ $totalPartidos }}</td>
                            <td class="text-center">{{ $totalGoles }}</td>
                            <td class="text-center">{{ $totalAsistencias }}</td>
                            <td class="text-center">
                                @if($totalAmarillass > 0)
                                    <span class="badge bg-warning text-dark">{{ $totalAmarillass }}</span>
                                @else 0 @endif
                            </td>
                            <td class="text-center">
                                @if($totalRojas > 0)
                                    <span class="badge bg-danger">{{ $totalRojas }}</span>
                                @else 0 @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row g-2 mt-2">
                <div class="col-6 col-md-3">
                    <div class="card border-0 bg-primary bg-opacity-10 text-center py-2 rounded-3">
                        <div class="fs-3 fw-bold text-primary">{{ $totalPartidos }}</div>
                        <div class="small text-muted" style="font-size:0.75rem;">Partidos jugados</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 bg-success bg-opacity-10 text-center py-2 rounded-3">
                        <div class="fs-3 fw-bold text-success">{{ $totalGoles }}</div>
                        <div class="small text-muted" style="font-size:0.75rem;">Goles</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 bg-info bg-opacity-10 text-center py-2 rounded-3">
                        <div class="fs-3 fw-bold text-info">{{ $totalAsistencias }}</div>
                        <div class="small text-muted" style="font-size:0.75rem;">Asistencias</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 bg-warning bg-opacity-10 text-center py-2 rounded-3">
                        <div class="fs-3 fw-bold text-warning">{{ $totalAmarillass }}</div>
                        <div class="small text-muted" style="font-size:0.75rem;">T. Amarillas</div>
                    </div>
                </div>
            </div>

        @else
            <div class="text-center py-4 bg-light rounded-3">
                <i class="bi bi-bar-chart text-muted fs-1 opacity-50"></i>
                <p class="mt-2 text-muted mb-0">No hay estadísticas registradas para este jugador.</p>
            </div>
        @endif
    </div>

    @php
        $Admin = Auth::user()->tipo_usuario === 'admin';
        $Ojeador = Auth::user()->tipo_usuario === 'ojeador';
        $informesPropios = $jugador->informes->filter(fn($inf) => $inf->ojeador?->usuario?->id === Auth::id());
        $mostrarInformes = $Admin || ($Ojeador && $informesPropios->count() > 0);
    @endphp

    @if($mostrarInformes)
    <div class="mt-4">
        <hr class="text-muted">
        <h4 class="h5 fw-bold mb-3">
            <i class="bi bi-journal-text me-2 text-primary"></i>Informes de Scouting
            <span class="badge bg-primary ms-1">
                {{ $Admin ? $jugador->informes->count() : $informesPropios->count() }}
            </span>
        </h4>

        @php
            $informesAMostrar = $Admin ? $jugador->informes : $informesPropios;
        @endphp

        @if($informesAMostrar->count() > 0)
        <div class="row g-3">
            @foreach($informesAMostrar as $informe)
            @php
                $partido = $informe->partido;
                $ojeadorInforme = $informe->ojeador;
                $potencial = $informe->Potencial ?? null;
                $potencialColor = match($potencial) {
                    'Alto'   => 'success',
                    'Medio'  => 'warning',
                    'Bajo'   => 'danger',
                    default  => 'secondary',
                };
            @endphp
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100 rounded-3" style="border-left: 4px solid var(--bs-{{ $potencialColor }}) !important;">
                    <div class="card-body">
                        {{-- Cabecera: partido --}}
                        @if($partido)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ $partido->Local?->url_logo }}" style="width:1.6em; height:1.6em; object-fit:contain;">
                            <span class="small fw-semibold">
                                {{ $partido->Local?->Nombre }} <strong>{{ $partido->Goles_Local }}</strong>
                                vs
                                <strong>{{ $partido->Goles_Visitante }}</strong> {{ $partido->Visitante?->Nombre }}
                            </span>
                            <img src="{{ $partido->Visitante?->url_logo }}" style="width:1.6em; height:1.6em; object-fit:contain;">
                        </div>
                        @endif

                        {{-- Ojeador + fecha --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted text-truncate me-2">
                                <i class="bi bi-person me-1"></i>
                                {{ $ojeadorInforme?->Nombre }} {{ $ojeadorInforme?->Apellido1 }}
                            </small>
                            <small class="text-muted flex-shrink-0">
                                <i class="bi bi-calendar me-1"></i>
                                {{ $informe->created_at ? \Carbon\Carbon::parse($informe->created_at)->format('d/m/Y') : '—' }}
                            </small>
                        </div>

                        {{-- Potencial --}}
                        @if($potencial)
                        <div class="mb-2">
                            <span class="badge bg-{{ $potencialColor }}">
                                Potencial: {{ $potencial }}
                            </span>
                        </div>
                        @endif

                        {{-- Valoraciones --}}
                        @if($informe->Valoracion_Tecnica || $informe->Valoracion_Tactica || $informe->Valoracion_Fisica)
                        <div class="row g-1 text-center mt-1">
                            @if($informe->Valoracion_Tecnica)
                            <div class="col-4">
                                <div class="bg-primary bg-opacity-10 rounded py-1">
                                    <div class="fw-bold text-primary">{{ $informe->Valoracion_Tecnica }}</div>
                                    <div class="text-muted" style="font-size:0.65rem;">TÉCNICA</div>
                                </div>
                            </div>
                            @endif
                            @if($informe->Valoracion_Tactica)
                            <div class="col-4">
                                <div class="bg-info bg-opacity-10 rounded py-1">
                                    <div class="fw-bold text-info">{{ $informe->Valoracion_Tactica }}</div>
                                    <div class="text-muted" style="font-size:0.65rem;">TÁCTICA</div>
                                </div>
                            </div>
                            @endif
                            @if($informe->Valoracion_Fisica)
                            <div class="col-4">
                                <div class="bg-success bg-opacity-10 rounded py-1">
                                    <div class="fw-bold text-success">{{ $informe->Valoracion_Fisica }}</div>
                                    <div class="text-muted" style="font-size:0.65rem;">FÍSICA</div>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        {{-- Enlace al informe --}}
                        <div class="mt-3">
                            <a href="{{ route('informes.ver', ['id' => $informe->ID_Informe]) }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-eye me-1"></i> Ver informe
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-4 bg-light rounded-3">
            <i class="bi bi-journal text-muted fs-1 opacity-50"></i>
            <p class="mt-2 text-muted mb-0">No hay informes de scouting para este jugador.</p>
        </div>
        @endif
    </div>
    @endif
    {{-- ===================================================================== --}}

</div>

@endsection
