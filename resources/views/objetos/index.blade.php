@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Objetos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Escritorio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('capas.index') }}">Capas</a></li>
                <li class="breadcrumb-item active">Objetos</li>
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
                            <h4>Objetos en la capa {{ $capa->nombre }}</h4>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('objetos.importar.form', $capa->id) }}" class="btn btn-success">
                                <i class="bi bi-file-excel"></i> Importar Excel
                            </a>
                            <a href="{{ route('capas.objetos.create', ['capa' => $capa->id]) }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Nuevo objeto
                            </a>
                            <a class="btn btn-secondary" href="{{ route('capas.index') }}"> Lista de capas</a>
                        </div>
                    </div>

                    <div class="d-flex gap-2">

                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Origen</th>
                            <td>Fuente</td>
                            <th width="280px">Accion</th>
                        </tr>
                        @foreach ($objetos as $objeto)
                            <tr>
                                <td>{{ $objeto->id }}</td>
                                <td>{{ $objeto->nombre }}</td>
                                <td>{{ $objeto->tipo }}</td>
                                <td>{{ $objeto->origen }}</td>
                                <td>{{ $objeto->fuente }}</td>
                                <td>
                                    @can('objetos-delete')
                                        <a class="btn btn-danger btn-sm" href="" data-bs-toggle="modal"
                                            data-bs-target="#modalEliminar{{ $objeto->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Eliminar objeto"><i class="fas fa-trash-alt"></i></a>
                                    @endcan
                                    <a class="btn btn-primary btn-sm" href="{{ route('objetos.show', $objeto->id) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar objeto"><i
                                            class="fas fa-map-marker-alt"></i></a>
                                    <a class="btn btn-success btn-sm" href="{{ route('objetos.edit', $objeto->id) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Editar objeto"><i
                                            class="fas fa-edit"></i></a>
                                </td>
                            </tr>

                            <!-- modalEliminar se muestra al hacer click en boton de borrar ------>
                            <div class="modal fade" id="modalEliminar{{ $objeto->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex justify-content-center">
                                            <h4>Eliminar Registro</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-center">Está seguro(a) de eliminar el registro
                                                {{ $objeto->nombre }}
                                                / ID: {{ $objeto->id }}?</p>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('objetos.destroy', $objeto->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Borrar"><i
                                                        class="fas fa-trash-alt"></i>
                                                    Borrar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><!--fin modal-->
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
@endpush
