@extends('layouts.escritorio')

@section('styles')

@endsection

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h1 mb-0 text-gray-800">Editar rol</h1>
        <div class="btn-group" role="group" aria-label="botones">
            <a class="d-sm-inline-block btn btn-danger shadow-sm" href="{{ route('roles.index') }}">
                <i class="fa-regular fa-circle-left"></i>
                Volver
            </a>
        </div>
    </div>

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
            <div class="card shadow">
                <div class="card-body mt-3">

                    <form method="post" action="{{ route('roles.update', $role->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" value={{ $role->name }} readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Permisos</label>
                            <div class="col-sm-4">
                                @foreach($permission as $value)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permission[]" id="{{ $value->id }}" value="{{ $value->name }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $value->id }}">
                                            {{ $value->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush
