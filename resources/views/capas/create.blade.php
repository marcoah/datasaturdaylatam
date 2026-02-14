@extends('layouts.escritorio')

@section('styles')
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Crear capa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('capas.index') }}">Capas</a></li>
                <li class="breadcrumb-item active">Crear capa</li>
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

                    <form method="POST" action="{{ route('capas.store') }}" accept-charset="UTF-8">
                        @csrf
                        <div class="card-body">

                            <h5 class="card-title">Nueva capa</h5>

                            <div class="row mb-3">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre de la capa</label>
                                <div class="col-sm-4">
                                    <input id="nombre" type="text" class="form-control" name="nombre" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputColor" class="col-sm-2 col-form-label">Color</label>
                                <div class="col-sm-10">
                                    <input type="color" class="form-control form-control-color" id="inputColor"
                                        name="color" value="#3388ff" title="Escoje el color">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Visible</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="isVisible" name="visible"
                                            value="1" {{ old('visible', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="isVisible">¿Capa visible?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="observaciones" class="col-sm-2 col-form-label">Observaciones</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Crear</button>
                            <a href="{{ route('capas.index') }}" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
@endpush
