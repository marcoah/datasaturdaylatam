@extends('layouts.escritorio')

@section('styles')
    <style>
        #finalizacion {
            transition: opacity 0.3s ease;
        }

        .is-invalid+.tox-tinymce {
            border: 2px solid #dc3545 !important;
            border-radius: 0.25rem;
        }
    </style>
@endsection

@section('content')

    <div class="pagetitle">
        <h1>Crear paseo</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('paseos.index') }}">paseos</a></li>
                <li class="breadcrumb-item active">Crear paseo</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <!-- Alerts Row -->
        <div class="row">
            <div class="col-sm-12 mb-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <form method="post" action="{{ route('paseos.store') }}" class="row g-3 needs-validation" novalidate
                    autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title">Nuevo paseo</h5>

                            <div class="row mb-3">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        value="{{ old('nombre') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                        rows="10">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ubicacion" class="col-sm-2 col-form-label">Punto reunión
                                </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="ubicacion" name="ubicacion"
                                        value="{{ old('ubicacion') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fecha_inicio" class="col-sm-2 col-form-label">Fecha inicio
                                </label>
                                <div class="col-lg-4">
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                        value="{{ old('fecha_inicio') }}" required>
                                </div>
                                <label for="hora_inicio" class="col-sm-2 col-form-label">Hora inicio
                                </label>
                                <div class="col-lg-4">
                                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio"
                                        value="{{ old('hora_inicio') }}" required>
                                </div>
                            </div>

                            <!-- Checkbox -->
                            <div class="row mb-3">
                                <legend class="col-form-label col-sm-2 pt-0"></legend>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1"
                                            name="mostrar_finalizacion" value="1">
                                        <label class="form-check-label" for="gridCheck1">
                                            Mostrar fecha y hora de finalización
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!--Finalizacion -->
                            <div id="finalizacion">
                                <div class="row mb-3">
                                    <label for="fecha_fin" class="col-sm-2 col-form-label">Fecha fin
                                    </label>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                                    </div>
                                    <label for="hora_fin" class="col-sm-2 col-form-label">Hora fin
                                    </label>
                                    <div class="col-lg-4">
                                        <input type="time" class="form-control" id="hora_fin" name="hora_fin">
                                    </div>
                                </div>
                            </div>

                            <!-- NUEVO: Campo de Imagen -->
                            <div class="row mb-3">
                                <label for="imagen" class="col-sm-2 col-form-label">Imagen Poster</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control @error('imagen') is-invalid @enderror"
                                        id="imagen" name="imagen" accept="image/*">
                                    @error('imagen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>

                                    <!-- Previsualización -->
                                    <div id="preview-container" class="mt-3" style="display: none;">
                                        <img id="preview-image" src="" alt="Vista previa" class="img-thumbnail"
                                            style="max-height: 200px;">
                                        <button type="button" class="btn btn-sm btn-danger mt-2" id="remove-image">
                                            <i class="bi bi-trash"></i> Quitar imagen
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="btn_1" class="col-sm-2 col-form-label">Texto boton 1
                                </label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" id="btn_1" name="btn_1"
                                        value="{{ old('btn_1') }}">
                                </div>
                                <label for="url_1" class="col-sm-1 col-form-label">URL 1
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="url_1" name="url_1"
                                        value="{{ old('url_1') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="btn_2" class="col-sm-2 col-form-label">Texto boton 2
                                </label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" id="btn_2" name="btn_2"
                                        value="{{ old('btn_2') }}">
                                </div>
                                <label for="url_2" class="col-sm-1 col-form-label">URL 2
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="url_2" name="url_2"
                                        value="{{ old('url_2') }}">
                                </div>
                            </div>

                            <hr>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
                                <a class="btn btn-danger btn-lg" href="{{ route('paseos.index') }}"
                                    role="button">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/inicia_tinymce.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('gridCheck1');
            const finalizacion = document.getElementById('finalizacion');
            const imagenInput = document.getElementById('imagen');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const removeButton = document.getElementById('remove-image');

            // Toggle finalizacion
            finalizacion.style.display = 'none';
            checkbox.addEventListener('change', function() {
                finalizacion.style.display = this.checked ? 'block' : 'none';
            });

            // Previsualización de imagen
            imagenInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    // Validar tipo de archivo
                    if (!file.type.startsWith('image/')) {
                        alert('Por favor selecciona un archivo de imagen válido');
                        imagenInput.value = '';
                        return;
                    }

                    // Validar tamaño (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('La imagen no debe superar los 2MB');
                        imagenInput.value = '';
                        return;
                    }

                    // Mostrar previsualización
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.style.display = 'none';
                }
            });

            // Quitar imagen
            removeButton.addEventListener('click', function() {
                imagenInput.value = '';
                previewContainer.style.display = 'none';
                previewImage.src = '';
            });
        });
    </script>
@endpush
