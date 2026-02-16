@extends('layouts.escritorio')

@section('content')
    <div class="pagetitle">
        <h1>Detalle de Noticia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}">Noticias</a></li>
                <li class="breadcrumb-item active">{{ $noticia->titulo }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    @if ($noticia->imagen)
                        <img src="{{ asset('storage/' . $noticia->imagen) }}" class="card-img-top"
                            alt="{{ $noticia->titulo }}" style="max-height: 400px; object-fit: cover;">
                    @endif

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h2 class="card-title display-6 fw-bold">{{ $noticia->titulo }}</h2>
                            @if ($noticia->publicada)
                                <span class="badge bg-success fs-6">Publicada</span>
                            @else
                                <span class="badge bg-secondary fs-6">Borrador</span>
                            @endif
                        </div>

                        <p class="text-muted mb-4">
                            <i class="bi bi-calendar-event me-2"></i>
                            {{ $noticia->fecha_publicacion->format('d/m/Y H:i') }}
                        </p>

                        <div class="mb-4">
                            <p class="lh-lg">{{ $noticia->contenido }}</p>
                        </div>

                        <div class="border-top pt-4 d-flex gap-2">
                            <a href="{{ route('noticias.edit', $noticia->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <a href="{{ route('noticias.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                            <form action="{{ route('noticias.destroy', $noticia->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta noticia?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
