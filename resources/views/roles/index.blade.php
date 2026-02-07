@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Administración de Roles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Administración de Roles</li>
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

        <!-- Tabla contenido -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div class="p-2 flex-grow-1">
                        <h4>Administración de Roles</h4>
                    </div>
                    <div class="p-2">
                        @can('role-create')
                            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Nuevo rol
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body mt-3">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Rol</th>
                                <th width="280px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ route('roles.show', $role->id) }}"
                                            data-toggle="tooltip" data-placement="top" title="Mostrar">
                                            <i class="fas fa-eye"></i> Mostrar
                                        </a>
                                        @can('role-edit')
                                            <a class="btn btn-sm btn-success" href="{{ route('roles.edit', $role->id) }}"
                                                data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        @endcan
                                        @can('role-delete')
                                            <a class="btn btn-sm btn-danger" href="" data-bs-toggle="modal"
                                                data-bs-target="#modalEliminar{{ $role->id }}" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i> Borrar
                                            </a>
                                            <div class="modal fade" id="modalEliminar{{ $role->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-flex justify-content-center">
                                                            <h4>Eliminar Registro</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Está seguro(a) de eliminar el rol
                                                                {{ $role->name }} / ID: {{ $role->id }} ?</p>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <form action="{{ route('roles.destroy', $role->id) }}"
                                                                method="post">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button class="btn btn-danger btn-sm" type="submit"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Borrar"><i class="fas fa-trash-alt"></i>
                                                                    Borrar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $roles->render() !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
@endpush
