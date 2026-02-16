@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>Editar Alerta</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('alertas.index') }}">Alertas</a></li>
                <li class="breadcrumb-item active">Editar</li>
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
                <form method="post" action="{{ route('alertas.update', $alerta->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Editar Alerta</h5>

                            <div class="row mb-3">
                                <label for="titulo" class="col-sm-2 col-form-label">Título</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                        id="titulo" name="titulo" value="{{ old('titulo', $alerta->titulo) }}" required>
                                    @error('titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="mensaje" class="col-sm-2 col-form-label">Mensaje</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control @error('mensaje') is-invalid @enderror" id="mensaje" name="mensaje" rows="4"
                                        required>{{ old('mensaje', $alerta->mensaje) }}</textarea>
                                    @error('mensaje')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="mensaje_adicional" class="col-sm-2 col-form-label">Mensaje Adicional</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control @error('mensaje_adicional') is-invalid @enderror" id="mensaje_adicional"
                                        name="mensaje_adicional" rows="2">{{ old('mensaje_adicional', $alerta->mensaje_adicional) }}</textarea>
                                    @error('mensaje_adicional')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Opcional - Se mostrará después de una línea separadora</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tipo" class="col-sm-2 col-form-label">Tipo de Alerta</label>
                                <div class="col-sm-10">
                                    <select class="form-select @error('tipo') is-invalid @enderror" id="tipo"
                                        name="tipo" required>
                                        <option value="">Seleccionar tipo...</option>
                                        <option value="primary"
                                            {{ old('tipo', $alerta->tipo) === 'primary' ? 'selected' : '' }}>Primary (Azul)
                                        </option>
                                        <option value="secondary"
                                            {{ old('tipo', $alerta->tipo) === 'secondary' ? 'selected' : '' }}>Secondary
                                            (Gris)</option>
                                        <option value="success"
                                            {{ old('tipo', $alerta->tipo) === 'success' ? 'selected' : '' }}>Success
                                            (Verde)</option>
                                        <option value="danger"
                                            {{ old('tipo', $alerta->tipo) === 'danger' ? 'selected' : '' }}>Danger (Rojo)
                                        </option>
                                        <option value="warning"
                                            {{ old('tipo', $alerta->tipo) === 'warning' ? 'selected' : '' }}>Warning
                                            (Amarillo)</option>
                                        <option value="info"
                                            {{ old('tipo', $alerta->tipo) === 'info' ? 'selected' : '' }}>Info (Cyan)
                                        </option>
                                        <option value="light"
                                            {{ old('tipo', $alerta->tipo) === 'light' ? 'selected' : '' }}>Light (Claro)
                                        </option>
                                        <option value="dark"
                                            {{ old('tipo', $alerta->tipo) === 'dark' ? 'selected' : '' }}>Dark (Oscuro)
                                        </option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="user_id" class="col-sm-2 col-form-label">Usuario (Opcional)</label>
                                <div class="col-sm-10">
                                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                        name="user_id">
                                        <option value="">Alerta Global (Todos los usuarios)</option>
                                        @foreach ($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}"
                                                {{ old('user_id', $alerta->user_id) == $usuario->id ? 'selected' : '' }}>
                                                {{ $usuario->fullname }} - {{ $usuario->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Deja vacío para que sea visible para todos los usuarios</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fecha_inicio" class="col-sm-2 col-form-label">Fecha Inicio</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                                        id="fecha_inicio" name="fecha_inicio"
                                        value="{{ old('fecha_inicio', $alerta->fecha_inicio?->format('Y-m-d')) }}">
                                    @error('fecha_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Opcional</div>
                                </div>
                                <label for="fecha_fin" class="col-sm-2 col-form-label">Fecha Fin</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror"
                                        id="fecha_fin" name="fecha_fin"
                                        value="{{ old('fecha_fin', $alerta->fecha_fin?->format('Y-m-d')) }}">
                                    @error('fecha_fin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Opcional</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="activa" name="activa"
                                            value="1" {{ old('activa', $alerta->activa) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activa">
                                            Alerta activa
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Actualizar
                                </button>
                                <a class="btn btn-secondary btn-lg" href="{{ route('alertas.index') }}">
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
