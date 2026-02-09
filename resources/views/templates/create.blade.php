@extends('layouts.dashboard')

@section('styles')

@endsection

@section('content')

    <div class="pagetitle">
        <h1>{{ __('Create Template') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('templates.index') }}">Templates</a></li>
                <li class="breadcrumb-item active">Create template</li>
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
                    <h5 class="card-title">Create Template</h5>

                    <!-- Horizontal Form -->
                    <form method="post" action="{{ route('templates.store') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <label for="template_title" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="template_title" id="template_title" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="template_subject" class="col-sm-2 col-form-label">Subject</label>
                            <div class="col-sm-10">
                                <input type="text" name="template_subject" id="template_subject" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Use</label>
                            <div class="col-sm-10">
                                <input type="text" name="template_use" id="template_use" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="template_intro" class="col-sm-2 col-form-label">Intro</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="template_intro" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="template_content_1" class="col-sm-2 col-form-label">Content 1</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="template_content_1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="template_content_2" class="col-sm-2 col-form-label">Content 2</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="template_content_2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="template_content_3" class="col-sm-2 col-form-label">Content 3</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="template_content_3" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="template_slug" class="col-sm-2 col-form-label">Slug</label>
                            <div class="col-sm-10">
                                <input type="text" name="template_slug" id="template_slug" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="col-sm-2 col-form-label">{{ __('Tags') }}</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="template_tags" name="template_tags[]" multiple>
                                    <option value="Notification">Notification</option>
                                    <option value="E-mail">E-mail</option>
                                    <option value="Account">Account</option>
                                    <option value="Setting">Setting</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Suspended">Suspended</option>
                                    <option value="Payment">Payment</option>
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
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('js/inicia_tinymce.js') }}"></script>
@endpush
