@extends('layouts.escritorio')

@section('styles')
@endsection

@section('content')

    <div class="pagetitle">
        <h1>Configuración</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
                <li class="breadcrumb-item active">Agregar</li>
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

        <!-- Content Row -->
        <div class="row">
            <div class="col-sm-12">
                @if (session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Envio de correo') }}</h5>

                        <form method="post" action="{{ url('test_email') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="destinatario" class="col-sm-2 col-form-label">Destinatario</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="destinatario" name="destinatario"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="asunto" class="col-sm-2 col-form-label">Asunto</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="asunto" name="asunto" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="mensaje" class="col-sm-2 col-form-label">Mensaje</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="mensaje" name="mensaje" required style="height: 100px;">Escribe aqui tu mensaje</textarea>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                                <a class="btn btn-secondary" href="{{ url()->previous() }}" role="button">Cancelar</a>
                                <button type="reset" class="btn btn-info">Reset</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/inicia_tinymce.js') }}"></script>
@endpush
