@extends('layouts.escritorio') {{-- O el layout que uses para vistas públicas --}}

@section('content')
    <div class="pagetitle">
        <h1>Noticias</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Noticias</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($noticias as $noticia)
                <div class="col">
                    <div class="card h-100">
                        @if ($noticia->imagen)
                            <img src="{{ asset('storage/' . $noticia->imagen) }}" class="card-img-top"
                                alt="{{ $noticia->titulo }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 200px;">
                                <i class="bi bi-newspaper text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $noticia->titulo }}</h5>
                            <p class="card-text text-muted mb-2">
                                <small>
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $noticia->fecha_publicacion->format('d/m/Y') }}
                                </small>
                            </p>
                            <p class="card-text">{{ Str::limit($noticia->contenido, 120) }}</p>
                            <a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-primary mt-auto">
                                Leer más <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        No hay noticias publicadas en este momento
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if ($noticias->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $noticias->links() }}
            </div>
        @endif
    </section>
@endsection
