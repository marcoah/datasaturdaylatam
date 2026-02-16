@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>Crear Ponencia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ponencias.index') }}">Ponencias</a></li>
                <li class="breadcrumb-item active">Crear Ponencia</li>
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
                <form method="post" action="{{ route('ponencias.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Datos del Ponente</h5>

                            <div class="row mb-3">
                                <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                        id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="apellido" class="col-sm-3 col-form-label">Apellido</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('apellido') is-invalid @enderror"
                                        id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                                    @error('apellido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Se creará un usuario con este email y se le enviará una
                                        contraseña temporal.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Datos de la Ponencia</h5>

                            <div class="row mb-3">
                                <label for="titulo" class="col-sm-3 col-form-label">Título</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                        id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                                    @error('titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                        rows="5" required>{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fecha_ponencia" class="col-sm-3 col-form-label">Fecha</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control @error('fecha_ponencia') is-invalid @enderror"
                                        id="fecha_ponencia" name="fecha_ponencia" value="{{ old('fecha_ponencia') }}"
                                        required>
                                    @error('fecha_ponencia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <label for="horario_ponencia" class="col-sm-2 col-form-label">Horario</label>
                                <div class="col-sm-2">
                                    <input type="time"
                                        class="form-control @error('horario_ponencia') is-invalid @enderror"
                                        id="horario_ponencia" name="horario_ponencia" value="{{ old('horario_ponencia') }}"
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
                                        <option value="basico" {{ old('nivel') === 'basico' ? 'selected' : '' }}>Básico
                                        </option>
                                        <option value="intermedio" {{ old('nivel') === 'intermedio' ? 'selected' : '' }}>
                                            Intermedio</option>
                                        <option value="avanzado" {{ old('nivel') === 'avanzado' ? 'selected' : '' }}>
                                            Avanzado</option>
                                    </select>
                                    @error('nivel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="archivo" class="col-sm-3 col-form-label">Archivo (opcional)</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control @error('archivo') is-invalid @enderror"
                                        id="archivo" name="archivo" accept=".pdf,.pptx,.ppt">
                                    @error('archivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Formatos permitidos: PDF, PPTX, PPT. Tamaño máximo: 10MB</div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Guardar Ponencia
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
