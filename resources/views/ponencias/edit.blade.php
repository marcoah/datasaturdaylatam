@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>Editar Ponencia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ponencias.index') }}">Ponencias</a></li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <!-- Alerts Row -->
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
                <form method="post" action="{{ route('ponencias.update', $ponencia->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ponente: {{ $ponencia->user->name }}</h5>
                            <p class="text-muted">{{ $ponencia->user->email }}</p>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Datos de la Ponencia</h5>

                            <div class="row mb-3">
                                <label for="titulo" class="col-sm-3 col-form-label">Título</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                        id="titulo" name="titulo" value="{{ old('titulo', $ponencia->titulo) }}"
                                        required>
                                    @error('titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                        rows="5" required>{{ old('descripcion', $ponencia->descripcion) }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fecha_ponencia" class="col-sm-3 col-form-label">Fecha</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control @error('fecha_ponencia') is-invalid @enderror"
                                        id="fecha_ponencia" name="fecha_ponencia"
                                        value="{{ old('fecha_ponencia', $ponencia->fecha_ponencia->format('Y-m-d')) }}"
                                        required>
                                    @error('fecha_ponencia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label for="horario_ponencia" class="col-sm-2 col-form-label">Horario</label>
                                <div class="col-sm-2">
                                    <input type="time"
                                        class="form-control @error('horario_ponencia') is-invalid @enderror"
                                        id="horario_ponencia" name="horario_ponencia"
                                        value="{{ old('horario_ponencia', substr($ponencia->horario_ponencia, 0, 5)) }}"
                                        required>
                                    @error('horario_ponencia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nivel" class="col-sm-3 col-form-label">Nivel</label>
                                <div class="col-sm-9">
                                    <select class="form-select @error('nivel') is-invalid @enderror" id="nivel"
                                        name="nivel" required>
                                        <option value="">Seleccionar nivel...</option>
                                        <option value="basico"
                                            {{ old('nivel', $ponencia->nivel) === 'basico' ? 'selected' : '' }}>Básico
                                        </option>
                                        <option value="intermedio"
                                            {{ old('nivel', $ponencia->nivel) === 'intermedio' ? 'selected' : '' }}>
                                            Intermedio</option>
                                        <option value="avanzado"
                                            {{ old('nivel', $ponencia->nivel) === 'avanzado' ? 'selected' : '' }}>Avanzado
                                        </option>
                                    </select>
                                    @error('nivel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="archivo" class="col-sm-3 col-form-label">Archivo</label>
                                <div class="col-sm-9">
                                    @if ($ponencia->archivo)
                                        <div class="mb-3">
                                            <p class="mb-2">
                                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                Archivo actual:
                                                <a href="{{ asset('storage/' . $ponencia->archivo) }}" target="_blank">
                                                    {{ basename($ponencia->archivo) }}
                                                </a>
                                            </p>
                                        </div>
                                    @endif

                                    <input type="file" class="form-control @error('archivo') is-invalid @enderror"
                                        id="archivo" name="archivo" accept=".pdf,.pptx,.ppt">
                                    @error('archivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        @if ($ponencia->archivo)
                                            Deja este campo vacío si no quieres cambiar el archivo actual.
                                        @else
                                            Formatos permitidos: PDF, PPTX, PPT. Tamaño máximo: 10MB
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Actualizar Ponencia
                                </button>
                                <a class="btn btn-secondary btn-lg" href="{{ route('ponencias.index') }}">
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
