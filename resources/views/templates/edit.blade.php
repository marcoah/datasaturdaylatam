@extends('layouts.escritorio')

@section('styles')
@endsection

@section('content')

    <div class="pagetitle">
        <h1>{{ __('Edit template') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('templates.index') }}">{{ __('Templates') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Edit template') }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Alerts Row -->
    <div class="row">
        <div class="col-lg-12 mb-4">
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

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Template</h5>

                        <!-- Horizontal Form -->
                        <form method="post" action="{{ route('templates.update', $template->id) }}"
                            class="needs-validation" novalidate>
                            @method('PATCH')
                            @csrf
                            <div class="row mb-3">
                                <label for="title" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-6">
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ old('title', $template->title) }}" required>
                                </div>

                                <label for="slug" class="col-sm-1 col-form-label"
                                    style="text-align: right;">Slug</label>
                                <div class="col-sm-3">
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        value="{{ old('slug', $template->slug) }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="subject" class="col-sm-2 col-form-label">Subject</label>
                                <div class="col-sm-6">
                                    <input type="text" name="subject" id="subject" class="form-control"
                                        value="{{ old('subject', $template->subject) }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Use</label>
                                <div class="col-sm-6">
                                    <input type="text" name="use" id="use" class="form-control"
                                        value="{{ old('use', $template->use) }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="intro" class="col-sm-2 col-form-label">Intro</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="intro" style="height: 100px">{{ old('intro', $template->intro) }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="content_1" class="col-sm-2 col-form-label">Content 1</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="content_1" style="height: 100px">{{ old('content_1', $template->content_1) }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="content_2" class="col-sm-2 col-form-label">Content 2</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="content_2" style="height: 100px">{{ old('content_2', $template->content_2) }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="content_3" class="col-sm-2 col-form-label">Content 3</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="content_3" style="height: 100px">{{ old('content_3', $template->content_3) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4 offset-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="has_cta" id="mostrarBotones"
                                            @if ($template->has_cta == 1) checked @endif>
                                        <label class="form-check-label" for="mostrarBotones">
                                            {{ __('Has a Call to action') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="button_div" id="button_div" style="display: none;">
                                <div class="row mb-3">
                                    <label for="button_text"
                                        class="col-sm-2 col-form-label">{{ __('Button text') }}</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="button_text" name="button_text"
                                            value="{{ $template->button_text }}">
                                    </div>
                                    <label for="button_link"
                                        class="col-sm-2 col-form-label">{{ __('Button link') }}</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="button_link" name="button_link"
                                            placeholder="https://domain.com/" value="{{ $template->button_link }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label class="col-sm-2 col-form-label">{{ __('Tags') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="tags" name="tags[]" multiple>
                                        <option value="Notification"
                                            {{ in_array('Notification', $template->tags ?? []) ? 'selected' : '' }}>
                                            Notification</option>
                                        <option value="E-mail"
                                            {{ in_array('E-mail', $template->tags ?? []) ? 'selected' : '' }}>
                                            E-mail</option>
                                        <option value="Account"
                                            {{ in_array('Account', $template->tags ?? []) ? 'selected' : '' }}>
                                            Account</option>
                                        <option value="Setting"
                                            {{ in_array('Setting', $template->tags ?? []) ? 'selected' : '' }}>
                                            Setting</option>
                                        <option value="Marketing"
                                            {{ in_array('Marketing', $template->tags ?? []) ? 'selected' : '' }}>
                                            Marketing</option>
                                        <option value="Inactive"
                                            {{ in_array('Inactive', $template->tags ?? []) ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="Suspended"
                                            {{ in_array('Suspended', $template->tags ?? []) ? 'selected' : '' }}>
                                            Suspended</option>
                                        <option value="Payment"
                                            {{ in_array('Payment', $template->tags ?? []) ? 'selected' : '' }}>
                                            Payment</option>
                                    </select>
                                    <small>{{ __('Press CTRL and click to multiple select') }}</small>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('templates.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form><!-- End Horizontal Form -->

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/inicia_tinymce.js') }}"></script>

    <script>
        // JavaScript para mostrar/ocultar el div con los botones
        document.getElementById('mostrarBotones').addEventListener('change', function() {
            var displayStyle = this.checked ? 'block' : 'none';
            document.getElementById('button_div').style.display = displayStyle;
        });

        // Mostrar el div si el checkbox está inicialmente marcado
        window.onload = function() {
            if (document.getElementById('mostrarBotones').checked) {
                document.getElementById('button_div').style.display = 'block';
            }
        }
    </script>
@endpush
