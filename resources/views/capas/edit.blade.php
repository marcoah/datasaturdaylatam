@extends('layouts.escritorio')

@section('styles')
@endsection

@section('content')

    <div class="pagetitle">
        <h1>Crear objeto</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('capas.index') }}">Capas</a></li>
                <li class="breadcrumb-item active">Crear punto</li>
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
            <div class="col-12">


                <div class="card">

                    <form action="{{ route('capas.update', $capa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">


                            <h5 class="card-title">Editar capa</h5>

                            <div class="row mb-3">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre de la capa</label>
                                <div class="col-sm-4">
                                    <input id="nombre" type="text" class="form-control" name="nombre"
                                        value="{{ old('nombre', $capa->nombre) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputColor" class="col-sm-2 col-form-label">Color</label>
                                <div class="col-sm-10">
                                    <input type="color" class="form-control form-control-color" id="inputColor"
                                        name="color" value="{{ old('color', $capa->color) }}" title="Escoje el color">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Visible</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="isVisible" name="visible"
                                            value="1" {{ old('visible', $capa->visible) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="isVisible">¿Capa visible?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="observaciones" class="col-sm-2 col-form-label">Observaciones</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $capa->observaciones) }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <a href="{{ route('capas.index') }}" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </main>
        </div>
        </div>
    @endsection

    @push('scripts')
    @endpush
