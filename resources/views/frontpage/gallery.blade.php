@extends('layouts.frontpage')

@section('styles')
    {{-- --}}
@endsection

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background"
        style="background-image: url({{ asset('frontpage/assets/img/events/showcase-9.webp') }});">
        <div class="container position-relative">
            <h1>Gallery</h1>
            <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda
                numquam molestias.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="current">Gallery</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

        <div class="container-fluid">

            <div class="row gy-4 justify-content-center">

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="gallery-item h-100">
                        <img src="{{ asset('frontpage/assets/img/events/gallery-1.webp') }}" class="img-fluid"
                            alt="">
                        <div class="gallery-links d-flex align-items-center justify-content-center">
                            <a href="{{ asset('frontpage/assets/img/events/gallery-1.webp') }}" title="Gallery 1"
                                class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                            <a href="{{ route('frontpage.gallery-single') }}" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="gallery-item h-100">
                        <img src="{{ asset('frontpage/assets/img/events/gallery-2.webp') }}" class="img-fluid"
                            alt="">
                        <div class="gallery-links d-flex align-items-center justify-content-center">
                            <a href="{{ asset('frontpage/assets/img/events/gallery-2.webp') }}" title="Gallery 2"
                                class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                            <a href="{{ route('frontpage.gallery-single') }}" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="gallery-item h-100">
                        <img src="{{ asset('frontpage/assets/img/events/gallery-3.webp') }}" class="img-fluid"
                            alt="">
                        <div class="gallery-links d-flex align-items-center justify-content-center">
                            <a href="{{ asset('frontpage/assets/img/events/gallery-3.webp') }}" title="Gallery 3"
                                class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                            <a href="{{ route('frontpage.gallery-single') }}" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="gallery-item h-100">
                        <img src="{{ asset('frontpage/assets/img/events/gallery-4.webp') }}" class="img-fluid"
                            alt="">
                        <div class="gallery-links d-flex align-items-center justify-content-center">
                            <a href="{{ asset('frontpage/assets/img/events/gallery-4.webp') }}" title="Gallery 4"
                                class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                            <a href="{{ route('frontpage.gallery-single') }}" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="gallery-item h-100">
                        <img src="{{ asset('frontpage/assets/img/events/gallery-5.webp') }}" class="img-fluid"
                            alt="">
                        <div class="gallery-links d-flex align-items-center justify-content-center">
                            <a href="{{ asset('frontpage/assets/img/events/gallery-5.webp') }}" title="Gallery 5"
                                class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                            <a href="{{ route('frontpage.gallery-single') }}" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="gallery-item h-100">
                        <img src="{{ asset('frontpage/assets/img/events/gallery-6.webp') }}" class="img-fluid"
                            alt="">
                        <div class="gallery-links d-flex align-items-center justify-content-center">
                            <a href="{{ asset('frontpage/assets/img/events/gallery-6.webp') }}" title="Gallery 6"
                                class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                            <a href="{{ route('frontpage.gallery-single') }}" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="gallery-item h-100">
                        <img src="{{ asset('frontpage/assets/img/events/gallery-7.webp') }}" class="img-fluid"
                            alt="">
                        <div class="gallery-links d-flex align-items-center justify-content-center">
                            <a href="{{ asset('frontpage/assets/img/events/gallery-7.webp') }}" title="Gallery 7"
                                class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                            <a href="{{ route('frontpage.gallery-single') }}" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="gallery-item h-100">
                        <img src="{{ asset('frontpage/assets/img/events/gallery-8.webp') }}" class="img-fluid"
                            alt="">
                        <div class="gallery-links d-flex align-items-center justify-content-center">
                            <a href="{{ asset('frontpage/assets/img/events/gallery-8.webp') }}" title="Gallery 8"
                                class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                            <a href="{{ route('frontpage.gallery-single') }}" class="details-link"><i
                                    class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div><!-- End Gallery Item -->

            </div>

        </div>

    </section><!-- /Gallery Section -->
@endsection

@push('scripts')
    {{-- --}}
@endpush
