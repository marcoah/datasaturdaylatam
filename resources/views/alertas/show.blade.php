@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>Detalle de Alerta</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('alertas.index') }}">Alertas</a></li>
                <li class="breadcrumb-item active">{{ $alerta->titulo }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <!-- Título y Estado -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h2 class="card-title display-6 fw-bold text-dark mb-3">{{ $alerta->titulo }}</h2>
                            </div>
                            <div>
                                @if ($alerta->activa)
                                    <span class="badge bg-success fs-6">
                                        <i class="bi bi-check-circle-fill"></i> Activa
                                    </span>
                                @else
                                    <span class="badge bg-secondary fs-6">
                                        <i class="bi bi-pause-circle"></i> Inactiva
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Preview de la Alerta -->
                        <div class="mb-4">
                            <h5 class="border-bottom border-2 pb-2 mb-3 text-secondary">Vista Previa</h5>
                            <div class="alert alert-{{ $alerta->tipo }} alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">{{ $alerta->titulo }}</h4>
                                <p>{{ $alerta->mensaje }}</p>

                                @if ($alerta->mensaje_adicional)
                                    <hr>
                                    <p class="mb-0">{{ $alerta->mensaje_adicional }}</p>
                                @endif

                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>

                        <!-- Información de la Alerta -->
                        <div class="alert alert-light border border-primary border-3 border-start mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-info-circle"></i> Información de la Alerta
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2">
                                        <strong>Tipo:</strong><br>
                                        <span class="badge bg-{{ $alerta->tipo }} fs-6">
                                            {{ ucfirst($alerta->tipo) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2">
                                        <strong>Destinatario:</strong><br>
                                        @if ($alerta->user)
                                            <i class="bi bi-person-fill text-primary me-1"></i>
                                            {{ $alerta->user->name }}<br>
                                            <small class="text-muted">{{ $alerta->user->email }}</small>
                                        @else
                                            <i class="bi bi-globe text-warning me-1"></i>
                                            <span class="text-muted">Alerta Global (Todos los usuarios)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if ($alerta->fecha_inicio || $alerta->fecha_fin)
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <p class="mb-2">
                                            <strong>Fecha de Inicio:</strong><br>
                                            @if ($alerta->fecha_inicio)
                                                <i class="bi bi-calendar-event text-info me-1"></i>
                                                {{ $alerta->fecha_inicio->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">Sin fecha de inicio</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <p class="mb-2">
                                            <strong>Fecha de Fin:</strong><br>
                                            @if ($alerta->fecha_fin)
                                                <i class="bi bi-calendar-check text-info me-1"></i>
                                                {{ $alerta->fecha_fin->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">Sin fecha de fin</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-12">
                                        <p class="mb-0">
                                            <strong>Vigencia:</strong>
                                            <span class="badge bg-info">Permanente</span>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Mensaje Principal -->
                        <div class="mb-4">
                            <h5 class="border-bottom border-2 pb-2 mb-3 text-secondary">Mensaje Principal</h5>
                            <div class="fs-6 lh-lg text-dark">
                                {{ $alerta->mensaje }}
                            </div>
                        </div>

                        <!-- Mensaje Adicional -->
                        @if ($alerta->mensaje_adicional)
                            <div class="mb-4">
                                <h5 class="border-bottom border-2 pb-2 mb-3 text-secondary">Mensaje Adicional</h5>
                                <div class="fs-6 lh-lg text-dark">
                                    {{ $alerta->mensaje_adicional }}
                                </div>
                            </div>
                        @endif

                        <!-- Metadatos -->
                        <div class="alert alert-light border mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-0">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-plus me-1"></i>
                                            Creada: {{ $alerta->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0">
                                        <small class="text-muted">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            Última actualización: {{ $alerta->updated_at->format('d/m/Y H:i') }}
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="border-top border-2 pt-4 d-flex flex-wrap gap-2">
                            <a href="{{ route('alertas.edit', $alerta->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i> Editar
                            </a>
                            <a href="{{ route('alertas.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Volver
                            </a>
                            <form action="{{ route('alertas.toggle', $alerta->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="btn btn-{{ $alerta->activa ? 'outline-warning' : 'success' }}">
                                    <i class="bi bi-{{ $alerta->activa ? 'pause' : 'play' }}-circle me-1"></i>
                                    {{ $alerta->activa ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                            <form action="{{ route('alertas.destroy', $alerta->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta alerta?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-1"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
