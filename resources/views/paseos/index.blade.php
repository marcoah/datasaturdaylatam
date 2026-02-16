@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Paseos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Paseos</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <!-- Alertas -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                @if (session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="p-2 flex-grow-1">
                            <h4>Administración paseos</h4>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('paseos.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Nuevo paseo
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover datatable" id="tabla" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Ubicacion</th>
                                    <th scope="col">Inicio</th>
                                    <th scope="col">Finalización</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paseos as $paseo)
                                    <tr>
                                        <td>{{ $paseo->id }}</td>
                                        <td>{{ $paseo->nombre }}</td>
                                        <td>{{ $paseo->ubicacion }}</td>
                                        <td>{{ $paseo->fecha_hora_inicio }}</td>
                                        <td>{{ $paseo->fecha_hora_fin }}</td>
                                        <td style="width: 140px;">
                                            @can('paseo-show')
                                                <a class="btn btn-primary btn-sm" href="{{ route('paseos.show', $paseo->id) }}"
                                                    data-toggle="tooltip" data-placement="top" title="Mostrar"><i
                                                        class="fas fa-eye"></i></a>
                                            @endcan
                                            @can('paseo-edit')
                                                <a class="btn btn-success btn-sm" href="{{ route('paseos.edit', $paseo->id) }}"
                                                    data-toggle="tooltip" data-placement="top" title="Editar"><i
                                                        class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('paseo-delete')
                                                <a class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modalEliminar{{ $paseo->id }}" title="Eliminar"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            @endcan
                                        </td>
                                    </tr>

                                    <!-- modalEliminar se muestra al hacer click en boton de borrar ------>
                                    <div class="modal fade" id="modalEliminar{{ $paseo->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar Registro
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-center">Está seguro(a) de eliminar el paseo
                                                        {{ $paseo->nombre }} | ID: {{ $paseo->id }}?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('paseos.destroy', $paseo->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit" title="Borrar"><i
                                                                class="fas fa-trash-alt"></i> Borrar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--fin modal-->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
@endpush
