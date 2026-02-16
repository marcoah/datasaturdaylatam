@extends('layouts.escritorio')

@section('content')
    <div class="pagetitle">
        <h1>Detalle de Ponencia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ponencias.index') }}">Ponencias</a></li>
                <li class="breadcrumb-item active">{{ $ponencia->titulo }}</li>
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
                                <h2 class="card-title display-6 fw-bold text-dark mb-3">{{ $ponencia->titulo }}</h2>
                            </div>
                            <div>
                                @if ($ponencia->aprobada)
                                    <span class="badge bg-success fs-6">
                                        <i class="bi bi-check-circle-fill"></i> Aprobada
                                    </span>
                                @else
                                    <span class="badge bg-warning fs-6">
                                        <i class="bi bi-clock"></i> Pendiente
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Información del Ponente -->
                        <div class="alert alert-light border border-primary border-3 border-start mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-person-circle"></i> Información del Ponente
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Nombre:</strong> {{ $ponencia->user->name }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Email:</strong>
                                        <a href="mailto:{{ $ponencia->user->email }}">{{ $ponencia->user->email }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles de la Ponencia -->
                        <div class="alert alert-light border border-info border-3 border-start mb-4">
                            <h6 class="text-info mb-3">
                                <i class="bi bi-calendar-event"></i> Detalles de la Ponencia
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2">
                                        <strong>Fecha y Hora:</strong><br>
                                        <i class="bi bi-calendar-check text-primary me-2"></i>
                                        {{ $ponencia->fecha_hora_ponencia }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2">
                                        <strong>Nivel:</strong><br>
                                        @if ($ponencia->nivel === 'basico')
                                            <span class="badge bg-success fs-6">
                                                <i class="bi bi-star"></i> Básico
                                            </span>
                                        @elseif($ponencia->nivel === 'intermedio')
                                            <span class="badge bg-warning fs-6">
                                                <i class="bi bi-star-fill"></i> Intermedio
                                            </span>
                                        @else
                                            <span class="badge bg-danger fs-6">
                                                <i class="bi bi-stars"></i> Avanzado
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <h5 class="border-bottom border-2 pb-2 mb-3 text-secondary">Descripción</h5>
                            <div class="fs-6 lh-lg text-dark">
                                {{ $ponencia->descripcion }}
                            </div>
                        </div>

                        <!-- Archivo -->
                        @if ($ponencia->archivo)
                            <div class="mb-4">
                                <h5 class="border-bottom border-2 pb-2 mb-3 text-secondary">Material de la Ponencia</h5>
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <i class="bi bi-file-earmark-pdf text-danger me-3" style="font-size: 2rem;"></i>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 fw-bold">{{ basename($ponencia->archivo) }}</p>
                                        <small class="text-muted">
                                            Formato: {{ strtoupper(pathinfo($ponencia->archivo, PATHINFO_EXTENSION)) }}
                                        </small>
                                    </div>
                                    <a href="{{ asset('storage/' . $ponencia->archivo) }}" target="_blank"
                                        class="btn btn-primary">
                                        <i class="bi bi-download"></i> Descargar
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Botones de Acción -->
                        <div class="border-top border-2 pt-4 d-flex flex-wrap gap-2">
                            <a href="{{ route('ponencias.edit', $ponencia->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i> Editar
                            </a>
                            <a href="{{ route('ponencias.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Volver
                            </a>
                            <form action="{{ route('ponencias.toggle', $ponencia->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="btn btn-{{ $ponencia->aprobada ? 'outline-warning' : 'success' }}">
                                    <i class="bi bi-{{ $ponencia->aprobada ? 'x-circle' : 'check-circle' }} me-1"></i>
                                    {{ $ponencia->aprobada ? 'Marcar como Pendiente' : 'Aprobar Ponencia' }}
                                </button>
                            </form>
                            <form action="{{ route('ponencias.destroy', $ponencia->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta ponencia?')">
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
