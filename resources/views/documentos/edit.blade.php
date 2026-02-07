@extends('layouts.escritorio')

@section('styles')

@endsection

@section('content')

    <div class="pagetitle">
        <h1>Editar cliente</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
                <li class="breadcrumb-item active">Editar cliente</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 mb-4">
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
            <div class="col-lg-12">
                <form method="post" action="{{ route('clientes.update', $cliente->id) }}" class="row g-3 needs-validation" novalidate autocomplete="off">
                    @method('PATCH')
                    @csrf

                    <ul class="nav nav-tabs mb-2" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-basico-tab" data-bs-toggle="pill" href="#pills-basico" role="tab" aria-controls="pills-basico" aria-selected="true">Datos Básicos</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-direcciones-tab" data-bs-toggle="pill" href="#pills-direcciones" role="tab" aria-controls="pills-direcciones" aria-selected="false">Direccion</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-usuarios-tab" data-bs-toggle="pill" href="#pills-usuarios" role="tab" aria-controls="pills-usuarios" aria-selected="false">Usuario asociado</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-basico" role="tabpanel" aria-labelledby="pills-basico-tab">
                            <!-- Fila Datos Basicos -->
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">Datos Basicos</div>
                                        <div class="card-body">
                                            <div class="row mt-3 mb-3">
                                                <label for="nombre" class="col-sm-4 col-form-label">Nombre del cliente</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{$cliente->nombre}}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="email1" class="col-sm-4 col-form-label">Correo Principal</label>
                                                <div class="col-sm-6">
                                                    <input type="email" class="form-control" id="email1" name="email1" value="{{ $cliente->email1 }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="email2" class="col-sm-4 col-form-label">Correo Secundario</label>
                                                <div class="col-sm-6">
                                                    <input type="email" class="form-control" id="email2" name="email2" value="{{ $cliente->email2 }}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="celular" class="col-sm-4 col-form-label">Celular</label>
                                                <div class="col-sm-6">
                                                    <input type="tel" class="form-control" id="celular" name="celular" value="{{ $cliente->celular }}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="telefono1" class="col-sm-4 col-form-label">Telefono principal</label>
                                                <div class="col-sm-6">
                                                    <input type="tel" class="form-control" id="telefono1" name="telefono1" value="{{ $cliente->telefono1 }}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="telefono2" class="col-sm-4 col-form-label">Telefono secundario</label>
                                                <div class="col-sm-6">
                                                    <input type="tel" class="form-control" id="telefono2" name="telefono2" value="{{ $cliente->telefono2 }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">Datos Tributarios</div>
                                        <div class="card-body">

                                            <fieldset class="row mt-3 mb-3">
                                                <legend class="col-form-label col-sm-2 pt-0">Tipo Cliente</legend>
                                                <div class="col-sm-10">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tipo" id="juridico" value="JURIDICO"  @if ($cliente->tipo == 'JURIDICO') {{ 'checked' }} @endif>
                                                        <label class="form-check-label" for="juridico">
                                                        Persona Juridica
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tipo" id="natural" value="NATURAL" @if ($cliente->tipo == 'NATURAL') {{ 'checked' }} @endif>
                                                        <label class="form-check-label" for="natural">
                                                        Persona Natural
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <div class="row mb-3">
                                                <label for="codigo_tributario" class="col-sm-2 col-form-label">Identificador Tributario</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="codigo_tributario" name="codigo_tributario" value="{{$cliente->codigo_tributario}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Final Fila Datos Basicos -->
                        </div>

                        <!-- Pestana Direccion -->
                        <div class="tab-pane fade" id="pills-direcciones" role="tabpanel" aria-labelledby="pills-direcciones-tab">
                            <!-- Fila Direccion Primaria -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">Direccion Primaria</div>
                                        <div class="card-body">
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label for="direccion1" class="form-label">Direccion</label>
                                                    <textarea class="form-control" id="direccion1" name="direccion1" rows=5>{{$cliente->direccion1}}</textarea>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="ciudad1" class="form-label">Ciudad</label>
                                                    <input type="text" class="form-control" id="ciudad1" name="ciudad1" value="{{$cliente->ciudad1}}">
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="estado1" class="form-label">Estado</label>
                                                    <input type="text" class="form-control" id="estado1" name="estado1" value="{{$cliente->estado1}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="postalcode1" class="form-label">Codigo Postal</label>
                                                    <input type="text" class="form-control" id="postalcode1" name="postalcode1" value="{{$cliente->postalcode1}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="pais1" class="form-label">Pais</label>
                                                    <input type="text" class="form-control" id="pais1" name="pais1" value="{{$cliente->pais1}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">Direccion Secundaria</div>
                                        <div class="card-body">
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label for="direccion2" class="form-label">Direccion</label>
                                                    <textarea class="form-control" id="direccion2" name="direccion2" rows=5>{{$cliente->direccion2}}</textarea>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="ciudad2" class="form-label">Ciudad</label>
                                                    <input type="text" class="form-control" id="ciudad2" name="ciudad2" value="{{$cliente->ciudad2}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="estado2" class="form-label">Estado</label>
                                                    <input type="text" class="form-control" id="estado2" name="estado2" value="{{$cliente->estado2}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="postalcode2" class="form-label">Codigo Postal</label>
                                                    <input type="text" class="form-control" id="postalcode2" name="postalcode2" value="{{$cliente->postalcode2}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="pais2" class="form-label">Pais</label>
                                                    <input type="text" class="form-control" id="pais2" name="pais2" value="{{$cliente->pais2}}">
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
                                            <div class="form-group row mt-3 mb-3">
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

                    <!-- Fila Botones -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
                                <a class="btn btn-danger btn-lg" href="{{ route('clientes.index') }}" role="button">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

@endpush
