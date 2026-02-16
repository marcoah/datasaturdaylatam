@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>Crear Noticia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}">Noticias</a></li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-sm-12 mb-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10">
                <form method="post" action="{{ route('noticias.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Nueva Noticia</h5>

                            <div class="row mb-3">
                                <label for="titulo" class="col-sm-2 col-form-label">Título</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                        id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                                    @error('titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="contenido" class="col-sm-2 col-form-label">Contenido</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control @error('contenido') is-invalid @enderror" id="contenido" name="contenido" rows="8"
                                        required>{{ old('contenido') }}</textarea>
                                    @error('contenido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control @error('imagen') is-invalid @enderror"
                                        id="imagen" name="imagen" accept="image/*">
                                    @error('imagen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Formatos: JPG, PNG, GIF. Máximo: 2MB</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fecha_publicacion" class="col-sm-2 col-form-label">Fecha de Publicación</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local"
                                        class="form-control @error('fecha_publicacion') is-invalid @enderror"
                                        id="fecha_publicacion" name="fecha_publicacion"
                                        value="{{ old('fecha_publicacion', now()->format('Y-m-d\TH:i')) }}" required>
                                    @error('fecha_publicacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="publicada" name="publicada"
                                            value="1" {{ old('publicada', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="publicada">
                                            Publicar noticia
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Guardar
                                </button>
                                <a class="btn btn-danger btn-lg" href="{{ route('noticias.index') }}">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/inicia_tinymce.js') }}"></script>
@endpush
