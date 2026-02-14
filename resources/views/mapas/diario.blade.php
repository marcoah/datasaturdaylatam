@extends('layouts.escritorio')

@section('content')
<div class="container">
    <div class="row">
        <!-- Contenido Central -->
        <main role="main" class="col-lg-12 col-sm-12 col-md-12 ml-sm-auto px-4">
            <div id="app"></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 col-sm-12 border-bottom">
                <h1> Reporte diario </h1>
                <div class="btn-toolbar mb-6 mb-md-0">
                    <div class="btn-group mr-6">
                        <a class="btn btn-success" href="#"><i class="fas fa-download fa-sm text-white-50"></i> Descargar Reporte</a>
                    </div>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </main>
    </div>
</div>

@endsection
