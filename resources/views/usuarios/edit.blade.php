@extends('layouts.escritorio')

@section('styles')
@endsection

@section('content')

    <div class="pagetitle">
        <h1>{{ __('Edit user') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Users list') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Edit user') }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h1 mb-0 text-gray-800">{{ __('Edit user') }}</h1>
            <div class="btn-group" role="group" aria-label="botones">
                <a class="d-sm-inline-block btn btn-danger shadow-sm" href="{{ route('users.index') }}">
                    <i class="fa-regular fa-circle-left"></i>
                    {{ __('Back') }}
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
            <div class="col-sm-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-body">

                        <form method="post" action="{{ route('users.update', $user->id) }}">
                            @method('PATCH')
                            @csrf

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('Firstname') }}:</strong>
                                        <input type="text" class="form-control" name="firstname" id="firstname"
                                            value={{ $user->firstname }}>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('Lastname') }}:</strong>
                                        <input type="text" class="form-control" name="lastname" id="lastname"
                                            value={{ $user->lastname }}>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('Username') }}:</strong>
                                        <input type="text" class="form-control" name="username" id="username"
                                            value={{ $user->username }}>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('E-Mail Address') }}:</strong>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value={{ $user->email }}>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('Password') }}:</strong>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('Confirm password') }}:</strong>
                                        <input type="password" class="form-control" name="confirm-password"
                                            id="confirm-password">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('Role') }}:</strong>
                                        <select class="form-select" name="roles[]" multiple>
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol }}"
                                                    {{ in_array($rol, $userRole) ? 'selected' : '' }}>{{ $rol }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-regular fa-floppy-disk"></i>
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
@endpush
