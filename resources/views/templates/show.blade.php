@extends('layouts.dashboard')

@section('content')

    <div class="pagetitle">
        <h1>{{ __('Template details') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">{{ __('Student List') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Student details') }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-3">



                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
@endpush
