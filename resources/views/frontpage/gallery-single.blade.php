@extends('layouts.frontpage')

@section('styles')
    {{-- --}}
@endsection

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background"
        style="background-image: url({{ asset('frontpage/assets/img/events/showcase-9.webp') }});">
        <div class="container position-relative">
            <h1>Gallery Single</h1>
            <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda
                numquam molestias.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="current">Galeria</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

        <div class="container-fluid">

            <div class="row gy-4 justify-content-center">

            </div>

        </div>

    </section><!-- /Gallery Section -->
@endsection

@push('scripts')
    {{-- --}}
@endpush
