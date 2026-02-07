@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Administración de Usuarios</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Administración de Usuarios</li>
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
                        <h4>Administración de Usuarios</h4>
                    </div>
                    <div class="p-2">
                        @can('users-create')
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Nuevo usuario
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
                                <th>{{ __('Full Name') }}</th>
                                <th>{{ __('E-Mail Address') }}</th>
                                <th>{{ __('Roles') }}</th>
                                <th>{{ __('Last access') }}</th>
                                <th width="280px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                <span class="badge text-bg-success">{{ $v }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $user->last_login_at ? Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'No login yet' }}
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ route('users.show', $user->id) }}"
                                            data-toggle="tooltip" data-placement="top" title="{{ __('Show') }}">
                                            <i class="fas fa-eye"></i> {{ __('Show') }}
                                        </a>

                                        @can('edit-users')
                                            <a class="btn btn-sm btn-success" href="{{ route('users.edit', $user->id) }}"
                                                data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                        @endcan

                                        @can('delete-users')
                                            <a class="btn btn-sm btn-danger" href="" data-bs-toggle="modal"
                                                data-bs-target="#modalEliminar{{ $user->id }}" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="{{ __('Delete') }}">
                                                <i class="fas fa-trash-alt"></i> {{ __('Delete') }}
                                            </a>
                                            <div class="modal fade" id="modalEliminar{{ $user->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-flex justify-content-center">
                                                            <h4>{{ __('Delete record') }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">{{ __('Are you sure to delete the') }}
                                                                {{ $user->fullname }} / ID: {{ $user->id }} ?</p>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="btn btn-sm btn-secondary"
                                                                data-bs-dismiss="modal">{{ __('Cancel') }}</button>

                                                            <form action="{{ route('users.destroy', $user->id) }}"
                                                                method="post" style="display:inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm" type="submit">
                                                                    <i class="fas fa-trash-alt"></i> {{ __('Delete') }}
                                                                </button>
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
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
@endpush
