@extends('layouts.escritorio')

@section('styles')

@endsection

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h1 mb-0 text-gray-800">Rol {{ $role->name }}</h1>
        <div class="btn-group" role="group" aria-label="botones">
            <a class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="{{ route('roles.index') }}">
                <i class="fa-regular fa-circle-left"></i>
                Volver
            </a>
            <a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="{{ route('roles.edit', $role->id)}}">
                <i class="fas fa-edit"></i>
                Editar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <ul class="list-group">
                <li class="list-group-item active" aria-current="true">Permisos</li>
                @if(!empty($rolePermissions))
                    @foreach($rolePermissions as $v)
                        <li class="list-group-item">{{ $v->name }}</li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush
