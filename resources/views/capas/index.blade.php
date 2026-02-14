@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Capas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Capas</li>
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
                            <h4>Capas para el proyecto</h4>
                        </div>
                        <div class="p-2">
                            <a class="btn btn-primary" href="{{ route('capas.create') }}"> Añadir capa</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Objetos</th>
                                <th>Descripcion</th>
                                <th>Visible?</th>
                                <th>Accion</th>
                            </tr>
                            @foreach ($capas as $capa)
                                <tr>
                                    <td>{{ $capa->id }}</td>
                                    <td>{{ $capa->nombre }}</td>
                                    <td>{{ $capa->objetos->count() }}</td>
                                    <td>{{ $capa->observaciones }}</td>
                                    <td class="text-center">
                                        @if ($capa->visible)
                                            <i class="fas fa-eye text-success fs-5" title="Visible"></i>
                                        @else
                                            <i class="fas fa-eye-slash text-secondary fs-5" title="Oculto"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @can('capas-delete')
                                            <a class="btn btn-danger btn-sm" href="" data-bs-toggle="modal"
                                                data-bs-target="#modalEliminar{{ $capa->id }}" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                                        @endcan
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('capas.objetos.index', ['capa' => $capa->id]) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar objetos"><i
                                                class="fas fa-eye"></i></a>
                                        <a class="btn btn-success btn-sm" href="{{ route('capas.edit', $capa->id) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Editar capa"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="btn btn-dark btn-sm" href="{{ route('mostrar.mapa', $capa->id) }}"
                                            data-toggle="tooltip" data-bs-placement="top" title="Mostrar mapa"><i
                                                class="fas fa-map-marker-alt"></i></a>
                                        <button class="btn btn-outline-success"
                                            onclick="window.location.href='{{ route('capas.exportar', $capa->id) }}'">
                                            Exportar a GeoJSON 🌍
                                        </button>
                                    </td>
                                </tr>

                                <!-- modalEliminar se muestra al hacer click en boton de borrar ------>
                                <div class="modal fade" id="modalEliminar{{ $capa->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex justify-content-center">
                                                <h4>Eliminar Registro</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center">Está seguro(a) de eliminar el registro
                                                    {{ $capa->nombre }} / ID: {{ $capa->id }}?</p>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('capas.destroy', $capa->id) }}" method="post">
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
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
@endpush
