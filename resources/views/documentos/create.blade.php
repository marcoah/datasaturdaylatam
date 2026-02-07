@extends('layouts.escritorio')

@section('styles')

@endsection

@section('content')

<div class="pagetitle">
    <h1>Crear cliente</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
            <li class="breadcrumb-item active">Crear cliente</li>
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
            <form method="post" action="{{ route('clientes.store') }}" class="row g-3 needs-validation" novalidate autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-basico-tab" data-bs-toggle="pill" href="#pills-basico" role="tab" aria-controls="pills-basico" aria-selected="true">Datos Básicos</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-direcciones-tab" data-bs-toggle="pill" href="#pills-direcciones" role="tab" aria-controls="pills-direcciones" aria-selected="false">Datos direcciones</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-usuarios-tab" data-bs-toggle="pill" href="#pills-usuarios" role="tab" aria-controls="pills-usuarios" aria-selected="false">Usuario asociado</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-basico" role="tabpanel" aria-labelledby="pills-basico-tab">
                                <!-- Fila Datos Basicos -->
                                <div class="row mt-3">
                                    <div class="col-lg-6 mb-3">
                                        <div class="card">
                                            <div class="card-header">Datos Nombre</div>
                                            <div class="card-body">

                                                <div class="row mb-3">
                                                    <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="nombre" name="nombre">
                                                    </div>
                                                </div>

                                                <fieldset class="row mb-3">
                                                    <legend class="col-form-label col-sm-2 float-sm-left pt-0">Tipo Cliente</legend>
                                                    <div class="col-sm-10">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="tipo" id="juridico" value="JURIDICO">
                                                            <label class="form-check-label" for="gridRadios1">Juridico</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="tipo" id="natural" value="NATURAL">
                                                            <label class="form-check-label" for="gridRadios2">Natural</label>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <div class="row mb-3">
                                                    <label for="codigo_tributario" class="col-sm-2 col-form-label">Codigo Tributario</label>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" id="codigo_tributario" name="codigo_tributario" disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label">Estatus</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-select" id="status" name="status" aria-label="estado del cliente">
                                                            <option value="Activo" selected>Activo</option>
                                                            <option value="Suspendido">Suspendido</option>
                                                            <option value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="card">
                                            <div class="card-header">Correos electrónicos</div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="email1" class="col-sm-4 col-form-label">Email 1</label>
                                                    <div class="col-sm-6">
                                                        <input type="email" class="form-control" id="email1" name="email1">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="email2" class="col-sm-4 col-form-label">Email 2</label>
                                                    <div class="col-sm-6">
                                                        <input type="email" class="form-control" id="email2" name="email2">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="celular" class="col-sm-4 col-form-label">Celular</label>
                                                    <div class="col-sm-6">
                                                        <input type="tel" class="form-control" id="celular" name="celular">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="telefono1" class="col-sm-4 col-form-label">Telefono 1</label>
                                                    <div class="col-sm-6">
                                                        <input type="tel" class="form-control" id="telefono1" name="telefono1">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="telefono2" class="col-sm-4 col-form-label">Telefono 2</label>
                                                    <div class="col-sm-6">
                                                        <input type="tel" class="form-control" id="telefono2" name="telefono2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- Final Fila Datos Basicos -->
                            </div>

                            <div class="tab-pane fade" id="pills-direcciones" role="tabpanel" aria-labelledby="pills-direcciones-tab">
                                <!-- Fila Direccion Primaria -->
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <div class="card">
                                            <div class="card-header">Direccion Primaria</div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="direccion1">Direccion</label>
                                                    <textarea class="form-control" id="direccion1" name="direccion1" rows=5></textarea>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="form-group col-md-3">
                                                        <label for="ciudad1">Ciudad</label>
                                                        <input type="text" class="form-control" id="ciudad1" name="ciudad1">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="estado1">Estado</label>
                                                        <input type="text" class="form-control" id="estado1" name="estado1">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="postalcode1">Codigo Postal</label>
                                                        <input type="text" class="form-control" id="postalcode1" name="postalcode1">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="pais1">Pais</label>
                                                        <input type="text" class="form-control" id="pais1" name="pais1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card">
                                            <div class="card-header">Direccion Secundaria</div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="direccion2">Direccion</label>
                                                    <textarea class="form-control" id="direccion2" name="direccion2" rows=5></textarea>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-3">
                                                        <label for="ciudad2">Ciudad</label>
                                                        <input type="text" class="form-control" id="ciudad2" name="ciudad2">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="estado2">Estado</label>
                                                        <input type="text" class="form-control" id="estado2" name="estado2">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="postalcode2">Codigo Postal</label>
                                                        <input type="text" class="form-control" id="postalcode2" name="postalcode2">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="pais2">Pais</label>
                                                        <input type="text" class="form-control" id="pais2" name="pais2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- Final Fila Direccion Personal -->
                            </div>

                            <div class="tab-pane fade" id="pills-usuarios" role="tabpanel" aria-labelledby="pills-usuarios-tab">
                                <!-- Fila Usuario Asociado -->
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <div class="card">
                                            <div class="card-header">Usuario Asociado</div>
                                            <div class="card-body">
                                                <div class="form-group row mb-3">
                                                    <label for="user_id" class="col-sm-4 col-form-label">Usuario</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select" id="user_id" name="user_id" aria-label="Seleccione un usuario">
                                                            <option value="" selected>Seleccione un usuario</option>
                                                            @foreach($usuarios as $usuario)
                                                                <option value="{{ $usuario->id }}">{{ $usuario->fullname }} - {{ $usuario->email }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- Final Fila Usuario Asociado -->
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
                        <a class="btn btn-danger btn-lg" href="{{ route('clientes.index') }}" role="button">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script type="text/javascript">

        var juridico = document.getElementById('juridico');
        var natural = document.getElementById('natural');
        var razonsocial = document.getElementById('nombre');
        var rif = document.getElementById('nit');

        function updateStatus() {
            if (juridico.checked) {
                razonsocial.disabled = false;
                rif.disabled = false;
                rif.setAttribute("value","J");
            } else {
                razonsocial.disabled = false;
                rif.disabled = false;
                rif.setAttribute("value","");
            }
        };

        juridico.addEventListener('change', updateStatus);
        natural.addEventListener('change', updateStatus);
    </script>
@endpush
