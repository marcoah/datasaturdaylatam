@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>Detalle del Paseo</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('paseos.index') }}">Paseos</a></li>
                <li class="breadcrumb-item active">{{ $paseo->nombre }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <!-- Imagen Poster -->
                    @if ($paseo->imagen)
                        <img src="{{ asset('storage/' . $paseo->imagen) }}" class="card-img-top" alt="{{ $paseo->nombre }}"
                            style="max-height: 400px; object-fit: cover;">
                    @else
                        <img src="{{ asset('assets/img/slides-1.jpg') }}" class="card-img-top" alt="{{ $paseo->nombre }}"
                            style="max-height: 400px; object-fit: cover;">
                    @endif

                    <div class="card-body">
                        <!-- Título principal -->
                        <h2 class="card-title display-5 fw-bold text-dark mb-4">{{ $paseo->nombre }}</h2>

                        <!-- Información de fecha y hora -->
                        <div class="alert alert-light border border-primary border-3 border-start mb-4">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <h6 class="text-primary mb-2">
                                        <i class="bi bi-calendar-event"></i> Inicio
                                    </h6>
                                    <p class="mb-0 fw-semibold">{{ $paseo->fecha_hora_inicio }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-2">
                                        <i class="bi bi-calendar-check"></i> Finalización
                                    </h6>
                                    <p class="mb-0 fw-semibold">{{ $paseo->fecha_hora_fin }}</p>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div>
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-geo-alt"></i> Punto reunión
                                </h6>
                                <p class="mb-0">{{ $paseo->ubicacion }}</p>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <h5 class="border-bottom border-2 pb-2 mb-3 text-secondary">Descripción</h5>
                            <div class="fs-6 lh-lg text-dark">
                                {!! $paseo->descripcion !!}
                            </div>
                        </div>

                        <!-- Botones de enlaces -->
                        @if ($paseo->url_1 || $paseo->url_2)
                            <div class="d-flex flex-wrap gap-3 mb-4">
                                @if ($paseo->url_1)
                                    <a href="{{ $paseo->url_1 }}" target="_blank" class="btn btn-primary btn-lg">
                                        <i class="bi bi-info-circle me-2"></i>{{ $paseo->btn_1 ?? 'Más información' }}
                                    </a>
                                @endif

                                @if ($paseo->url_2)
                                    <a href="{{ $paseo->url_2 }}" target="_blank" class="btn btn-outline-primary btn-lg">
                                        <i class="bi bi-globe me-2"></i>{{ $paseo->btn_2 ?? 'Más información' }}
                                    </a>
                                @endif
                            </div>
                        @endif

                        <!-- Botones de acción -->
                        <div class="border-top border-2 pt-4 d-flex flex-wrap gap-2">
                            <a href="{{ route('paseos.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Volver
                            </a>
                            @can('paseos-update')
                                <a href="{{ route('paseos.edit', $paseo->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i> Editar
                                </a>
                            @endcan
                            @can('paseos-delete')
                                <form action="{{ route('paseos.destroy', $paseo->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Está seguro de eliminar este paseo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
