@extends('layouts.escritorio')

@section('styles')

@endsection

@section('content')

<div class="pagetitle">
    <h1>Detalle cliente</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Lista</a></li>
            <li class="breadcrumb-item active">Detalle</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <!-- Título alineado a la izquierda -->
                    <h3>Cliente: {{$cliente->nombre}}</h3><br>
                    <h3>{{ $cliente->codigo_tributario }}</h3>


                    <!-- Botones alineados a la derecha en pantallas grandes -->
                    <div class="d-flex flex-wrap gap-2">
                        <a class="d-none d-sm-inline-block btn btn-primary" href="{{ route('clientes.index') }}">
                            <i class="fas fa-arrow-alt-circle-left fa-sm text-white-50"></i> Volver
                        </a>
                        <a class="d-none d-sm-inline-block btn btn-success" href="{{ route('clientes.edit', $cliente->id) }}">
                            <i class="fas fa-edit fa-sm text-white-50"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12 mb-3">

                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-contacto-tab" data-bs-toggle="pill" data-bs-target="#pills-contacto" type="button" role="tab" aria-controls="pills-contacto" aria-selected="true">Contacto</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-documentos-tab" data-bs-toggle="pill" data-bs-target="#pills-documentos" type="button" role="tab" aria-controls="pills-documentos" aria-selected="false">Documentos</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-contacto" role="tabpanel" aria-labelledby="pills-contacto-tab" tabindex="0">
                                <!--Contacto -->
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">


                                            <div class="card">
                                                <div class="card-body">

                                                    <label for="email1" class="col-sm-2 col-form-label">Correo principal</label>
                                                    <div class="col-sm-4">
                                                        {{ $cliente->email1 }}
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button id="envio_prueba" class="btn btn-primary" data-email="{{ $cliente->email1 }}">
                                                            Enviar correo de prueba
                                                        </button>
                                                    </div>

                                                    <!-- Contenedor para mostrar la respuesta -->
                                                    <div id="resultado_envio" class="mt-3"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <label for="email2" class="col-sm-2 col-form-label">Correo secundario</label>
                                            <div class="col-sm-10">
                                                {{ $cliente->email2 }}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="celular" class="col-sm-2 col-form-label">Celular</label>
                                            <div class="col-sm-10">
                                                <p>{{ $cliente->celular }} <a href="https://wa.me/{{ $cliente->celular }}" class="btn btn-success btn-sm" role="button" data-toggle="tooltip" data-placement="top" title="Enviar mensaje a Whatsapp" target="_blank"><span><i class="fab fa-whatsapp"></i></span></a></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="telefono1" class="col-sm-2 col-form-label">Telefono principal</label>
                                            <div class="col-sm-4">
                                                <strong>{{ $cliente->telefono1 }}</strong>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="telefono2" class="col-sm-2 col-form-label">Telefono secundario</label>
                                            <div class="col-sm-4">
                                                <strong>{{ $cliente->telefono2 }}</strong>
                                            </div>
                                        </div>

                                    </div>
                                </div><!-- En COntacto -->
                            </div>

                            <div class="tab-pane fade" id="pills-documentos" role="tabpanel" aria-labelledby="pills-documentos-tab" tabindex="0">
                                <!-- Documentos -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <strong>Documentos</strong>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Tipo</th>
                                                                <th scope="col">Total BS</th>
                                                                <th scope="col">Total USD</th>
                                                                <th scope="col">Estado documento</th>
                                                                <th scope="col">Fecha</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($documentos as $documento)
                                                            <tr>
                                                                <th scope="row"><a href="{{ route('documentos.show',$documento->id) }}">{{ $documento->id }}</a></th>

                                                                <td>{{ $documento->tipo }}- {{ $documento->numero }}</td>
                                                                <td>{{ number_format($documento->total, 2, ',', '.') }}</td>
                                                                <td>{{ number_format($documento->total, 2, ',', '.') }}</td>
                                                                <td>
                                                                    @if ($documento->status === "PAGADO")
                                                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Pagado</span>
                                                                    @else
                                                                        <span class="badge bg-danger">{{ $documento->status }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ date('d/m/Y', strtotime($documento->fecha_emision)) }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Documentos -->
                            </div>
                        </div>










</section>

@endsection

@push('scripts')
<script>
    document.getElementById("envio_prueba").addEventListener("click", function() {
        let email = this.getAttribute("data-email"); // Obtener el correo del atributo data-email
        let url = `/send-test-email/${email}`; // Construir la URL dinámica

        // Mostrar un mensaje de carga
        document.getElementById("resultado_envio").innerHTML = "<p>Enviando correo...</p>";

        // Hacer la petición con Fetch
        fetch(url)
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            // Mostrar la respuesta del servidor
            document.getElementById("resultado_envio").innerHTML = `<p>${data.message}</p>`;
        })
        .catch(error => {
            // Manejo de errores
            document.getElementById("resultado_envio").innerHTML = "<p>Error al enviar el correo</p>";
            console.error("Error:", error);
        });
    });
</script>
@endpush
