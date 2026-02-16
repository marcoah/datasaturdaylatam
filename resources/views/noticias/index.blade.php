@extends('layouts.escritorio')

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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Lista de Noticias</h5>
                            <a href="{{ route('noticias.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Crear Noticia
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Título</th>
                                        <th>Fecha Publicación</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($noticias as $noticia)
                                        <tr>
                                            <td>
                                                @if ($noticia->imagen)
                                                    <img src="{{ asset('storage/' . $noticia->imagen) }}"
                                                        alt="{{ $noticia->titulo }}"
                                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px; border-radius: 4px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $noticia->titulo }}</strong><br>
                                                <small class="text-muted">{{ Str::limit($noticia->contenido, 60) }}</small>
                                            </td>
                                            <td>
                                                <i class="bi bi-calendar-event text-info me-1"></i>
                                                {{ $noticia->fecha_publicacion->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                @if ($noticia->publicada)
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i> Publicada
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-eye-slash"></i> Borrador
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('noticias.show', $noticia->id) }}"
                                                        class="btn btn-info" title="Ver">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('noticias.edit', $noticia->id) }}"
                                                        class="btn btn-warning" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('noticias.destroy', $noticia->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('¿Estás seguro de eliminar esta noticia?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Eliminar">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-2">No hay noticias registradas</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($noticias->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $noticias->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
