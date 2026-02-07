@extends('layouts.escritorio')

@section('styles')
@endsection

@section('content')

    <div class="pagetitle">
        <h1>Agregar usuario</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
                <li class="breadcrumb-item active">Agregar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
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

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Add user') }}</h5>
                        <form method="post" action="{{ route('users.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="firstname" class="col-sm-2 col-form-label">{{ __('Firstname') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="firstname" id="firstname"
                                        value={{ old('firstname') }}>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="lastname" class="col-sm-2 col-form-label">{{ __('Lastname') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="lastname" id="lastname"
                                        value={{ old('lastname') }}>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{ __('E-Mail Address') }}</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" id="email"
                                        value={{ old('email') }}>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="confirm-password"
                                    class="col-sm-2 col-form-label">{{ __('Confirm password') }}</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="confirm-password"
                                        id="confirm-password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="roles" class="col-sm-2 col-form-label">{{ __('Role') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="roles[]" multiple>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol }}">{{ $rol }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-regular fa-floppy-disk"></i>
                                    {{ __('Save') }}
                                </button>
                                <a class="btn btn-danger" href="{{ route('users.index') }}">
                                    <i class="fa-regular fa-circle-left"></i>
                                    {{ __('Back') }}
                                </a>
                            </div>
                        </form><!-- End Horizontal Form -->
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')
@endpush
