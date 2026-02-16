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
        <h1>Editar paseo</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('paseos.index') }}">Paseos</a></li>
                <li class="breadcrumb-item active">Editar paseo</li>
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

                <form method="post" action="{{ route('paseos.update', $paseo->id) }}" class="row g-3 needs-validation"
                    novalidate autocomplete="off" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf

                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title">Editar paseo</h5>

                            <div class="row mb-3">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                        id="nombre" name="nombre" value="{{ old('nombre', $paseo->nombre) }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Campo de Imagen -->
                            <div class="row mb-3">
                                <label for="imagen" class="col-sm-2 col-form-label">Imagen Poster</label>
                                <div class="col-sm-10">
                                    <!-- Imagen actual -->
                                    @if ($paseo->imagen)
                                        <div id="current-image-container" class="mb-3">
                                            <img src="{{ asset('storage/' . $paseo->imagen) }}" alt="Imagen actual"
                                                class="img-thumbnail" style="max-height: 200px;">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="eliminar_imagen"
                                                    name="eliminar_imagen" value="1">
                                                <label class="form-check-label text-danger" for="eliminar_imagen">
                                                    <i class="bi bi-trash"></i> Eliminar imagen actual
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Input para nueva imagen -->
                                    <input type="file" class="form-control @error('imagen') is-invalid @enderror"
                                        id="imagen" name="imagen" accept="image/*">
                                    @error('imagen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        @if ($paseo->imagen)
                                            Deja este campo vacío si no quieres cambiar la imagen actual.
                                        @else
                                            Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                                        @endif
                                    </div>

                                    <!-- Previsualización de nueva imagen -->
                                    <div id="preview-container" class="mt-3" style="display: none;">
                                        <p class="fw-bold text-success">Nueva imagen:</p>
                                        <img id="preview-image" src="" alt="Vista previa" class="img-thumbnail"
                                            style="max-height: 200px;">
                                        <button type="button" class="btn btn-sm btn-danger mt-2" id="remove-image">
                                            <i class="bi bi-trash"></i> Cancelar cambio
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                        rows="10" required>{{ old('descripcion', $paseo->descripcion) }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ubicacion" class="col-sm-2 col-form-label">Punto reunión</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control @error('ubicacion') is-invalid @enderror"
                                        id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $paseo->ubicacion) }}"
                                        required>
                                    @error('ubicacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fecha_inicio" class="col-sm-2 col-form-label">Fecha inicio</label>
                                <div class="col-lg-4">
                                    <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                                        id="fecha_inicio" name="fecha_inicio"
                                        value="{{ old('fecha_inicio', $paseo->fecha_inicio->format('Y-m-d')) }}" required>
                                    @error('fecha_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label for="hora_inicio" class="col-sm-2 col-form-label">Hora inicio</label>
                                <div class="col-lg-4">
                                    <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror"
                                        id="hora_inicio" name="hora_inicio"
                                        value="{{ old('hora_inicio', $paseo->hora_inicio) }}" required>
                                    @error('hora_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Checkbox -->
                            <div class="row mb-3">
                                <legend class="col-form-label col-sm-2 pt-0"></legend>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1"
                                            name="mostrar_finalizacion" value="1"
                                            {{ $paseo->fecha_fin || $paseo->hora_fin ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridCheck1">
                                            Mostrar fecha y hora de finalización
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="finalizacion">
                                <div class="row mb-3">
                                    <label for="fecha_fin" class="col-sm-2 col-form-label">Fecha fin</label>
                                    <div class="col-lg-4">
                                        <input type="date"
                                            class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin"
                                            name="fecha_fin"
                                            value="{{ old('fecha_fin', $paseo->fecha_fin?->format('Y-m-d')) }}">
                                        @error('fecha_fin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <label for="hora_fin" class="col-sm-2 col-form-label">Hora fin</label>
                                    <div class="col-lg-4">
                                        <input type="time" class="form-control @error('hora_fin') is-invalid @enderror"
                                            id="hora_fin" name="hora_fin"
                                            value="{{ old('hora_fin', $paseo->hora_fin) }}">
                                        @error('hora_fin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="btn_1" class="col-sm-2 col-form-label">Texto boton 1
                                </label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control @error('btn_1') is-invalid @enderror"
                                        id="btn_1" name="btn_1" value="{{ old('btn_1', $paseo->btn_1) }}">
                                    @error('btn_1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label for="url_1" class="col-sm-1 col-form-label">URL 1
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control @error('url_1') is-invalid @enderror"
                                        id="url_1" name="url_1" value="{{ old('url_1', $paseo->url_1) }}">
                                    @error('url_1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="btn_2" class="col-sm-2 col-form-label">Texto boton 2
                                </label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control @error('btn_2') is-invalid @enderror"
                                        id="btn_2" name="btn_2" value="{{ old('btn_2', $paseo->btn_2) }}">
                                    @error('btn_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label for="url_2" class="col-sm-1 col-form-label">URL 2
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control @error('url_2') is-invalid @enderror"
                                        id="url_2" name="url_2" value="{{ old('url_2', $paseo->url_2) }}">
                                    @error('url_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
            const eliminarImagenCheckbox = document.getElementById('eliminar_imagen');
            const currentImageContainer = document.getElementById('current-image-container');

            // Mostrar u ocultar según si hay datos de finalización
            const tieneFechaFin = {{ $paseo->fecha_fin || $paseo->hora_fin ? 'true' : 'false' }};
            finalizacion.style.display = tieneFechaFin ? 'block' : 'none';

            // Toggle al cambiar el checkbox de finalización
            checkbox.addEventListener('change', function() {
                finalizacion.style.display = this.checked ? 'block' : 'none';
            });

            // Previsualización de nueva imagen
            if (imagenInput) {
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

                        // Desmarcar checkbox de eliminar si estaba marcado
                        if (eliminarImagenCheckbox) {
                            eliminarImagenCheckbox.checked = false;
                        }
                    } else {
                        previewContainer.style.display = 'none';
                    }
                });

                // Quitar nueva imagen seleccionada
                if (removeButton) {
                    removeButton.addEventListener('click', function() {
                        imagenInput.value = '';
                        previewContainer.style.display = 'none';
                        previewImage.src = '';
                    });
                }
            }

            // Ocultar imagen actual si se marca eliminar
            if (eliminarImagenCheckbox) {
                eliminarImagenCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        if (currentImageContainer) {
                            currentImageContainer.querySelector('img').style.opacity = '0.3';
                        }
                        // Limpiar nueva imagen si había una seleccionada
                        imagenInput.value = '';
                        previewContainer.style.display = 'none';
                    } else {
                        if (currentImageContainer) {
                            currentImageContainer.querySelector('img').style.opacity = '1';
                        }
                    }
                });
            }
        });
    </script>
@endpush
