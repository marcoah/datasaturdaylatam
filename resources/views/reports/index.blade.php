@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Reportes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Reportes</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
@endpush
