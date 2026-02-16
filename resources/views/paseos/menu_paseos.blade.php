@extends('layouts.escritorio')

@section('content')
    <div class="pagetitle">
        <h1>Paseos Disponibles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Paseos</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($paseos as $paseo)
                <div class="col">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <!-- Imagen del paseo -->
                        @if ($paseo->imagen)
                            <img src="{{ asset('storage/' . $paseo->imagen) }}" class="card-img-top"
                                alt="{{ $paseo->nombre }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <!-- Título -->
                            <h5 class="card-title fw-bold text-dark mb-3">{{ $paseo->nombre }}</h5>

                            <!-- Información -->
                            <div class="mb-auto">
                                <!-- Ubicación -->
                                <p class="card-text mb-2">
                                    <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                    <span class="text-muted">{{ Str::limit($paseo->ubicacion, 50) }}</span>
                                </p>

                                <!-- Fecha de inicio -->
                                <p class="card-text mb-0">
                                    <i class="bi bi-calendar-event-fill text-primary me-2"></i>
                                    <span class="fw-semibold">{{ $paseo->fecha_hora_inicio }}</span>
                                </p>
                            </div>

                            <!-- Botón -->
                            <div class="mt-3">
                                <a href="{{ route('paseos.show', $paseo->id) }}" class="btn btn-primary w-100">
                                    <i class="bi bi-eye me-2"></i>Ver Detalles
                                </a>
                            </div>
                        </div>

                        <!-- Badge si es próximo o en curso -->
                        @if ($paseo->estado == 'proximo')
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-success rounded-pill">
                                    <i class="bi bi-star-fill me-1"></i>Próximo
                                </span>
                            </div>
                        @elseif($paseo->estado == 'en_curso')
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-danger rounded-pill">
                                    <i class="bi bi-broadcast me-1"></i>En curso
                                </span>
                            </div>
                        @endif


                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <h5 class="mb-1">No hay paseos disponibles</h5>
                            <p class="mb-0">Por el momento no hay paseos programados. Vuelve pronto para conocer las
                                próximas actividades.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if ($paseos->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $paseos->links() }}
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection

@section('styles')
    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .card {
            position: relative;
            overflow: hidden;
        }

        .card-img-top {
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }
    </style>
@endsection
