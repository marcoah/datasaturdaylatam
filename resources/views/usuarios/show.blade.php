@extends('layouts.escritorio')

@section('styles')

@endsection

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h1 mb-0 text-gray-800">Detalle de usuario</h1>
        <div class="btn-group" role="group" aria-label="botones">
            <a class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="{{ route('users.index') }}">
                <i class="fa-regular fa-circle-left"></i>
                Volver
            </a>
            <a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="{{ route('users.edit', $user->id)}}">
                <i class="fas fa-edit"></i>
                Editar
            </a>
        </div>
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Hola, {{ $user->getfullname() }}</h1>
        <p class="lead">El correo asociado a la cuenta es {{ $user->email }}.</p>
        <hr class="my-4">
        <p>Tu ultimo cambio de perfil fue {{ $user->updated_at->diffForHumans() }}.</p>
        <h5>Tu nivel de acceso es
            <div class="form-group">
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                        <span class="badge text-bg-success">{{ $v }}</span>
                    @endforeach
                @endif
            </div>
        </h5>
    </div>

</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
@endpush
