@extends('layouts.asistente')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/intl-tel-input/css/intlTelInput.css') }}">
    <style>
        /* Integrar intl-tel-input con Bootstrap 5 */
        .iti {
            display: block;
            width: 100%;
        }

        .iti__flag-container {
            padding: 0;
        }

        .iti__selected-flag {
            padding: 0 8px 0 12px;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .iti__arrow {
            margin-left: 6px;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid #6c757d;
        }

        .iti__country-list {
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: 1px solid #dee2e6;
            max-height: 200px;
        }

        .iti__country {
            padding: 8px 12px;
        }

        .iti__country:hover {
            background-color: #f8f9fa;
        }

        .iti__country.iti__highlight {
            background-color: #e9ecef;
        }

        .iti__selected-dial-code {
            margin-left: 6px;
            color: #6c757d;
        }

        .iti input.form-control {
            padding-left: 52px;
        }

        .iti input.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .iti input.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>{{ __('Profile') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Profile') }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <!-- Success Row-->
        <div class="row">
            <div class="col-lg-12 mb-4">
                @if (session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>
        </div><!-- End Success Row-->

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
        </div><!-- End Alerts Row -->

        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ $user->avatar_url }}" alt="Profile" class="rounded-circle">

                        <h2>{{ $user->fullname }}</h2>
                        <h3>{{ $user->profile->job }}</h3>
                        <div class="social-links mt-2">
                            @if ($user->profile->twitter)
                                <a href="{{ 'https://x.com/' . $user->profile->twitter }}" class="twitter" target="_blank">
                                    <i class="bi bi-twitter"></i>
                                </a>
                            @endif
                            @if ($user->profile->facebook)
                                <a href="{{ 'https://facebook.com/' . $user->profile->facebook }}" class="facebook"
                                    target="_blank">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endif
                            @if ($user->profile->instagram)
                                <a href="{{ 'https://instagram.com/' . $user->profile->instagram }}" class="instagram"
                                    target="_blank">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif
                            @if ($user->profile->linkedin)
                                <a href="{{ 'https://www.linkedin.com/in/' . $user->profile->linkedin }}" class="linkedin"
                                    target="_blank">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            @endif
                            @if ($user->profile->website)
                                <a href="{{ $user->profile->website }}" class="website" target="_blank">
                                    <i class="bi bi-browser-chrome"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">{{ __('Overview') }}</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                    {{ __('Edit Profile') }}</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-settings">{{ __('Settings') }}</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">{{ __('Change Password') }}</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">{{ __('About') }}</h5>
                                <p class="small fst-italic">{{ $user->profile->about }}</p>

                                <h5 class="card-title">{{ __('Profile Details') }}</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">{{ __('Full Name') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->fullname }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('Company') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->profile->company }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('Job') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->profile->job }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('Website') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->profile->website }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('Country') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->profile->country }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('Address') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->profile->address }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('Phone') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->profile->phone }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">{{ __('Email') }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form method="post" action="{{ route('profile.update', $user->id) }}"
                                    class="row g-3 needs-validation" enctype="multipart/form-data" autocomplete="off">
                                    @method('PATCH')
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">
                                            {{ __('Profile Image') }}
                                        </label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/profile-img.jpg') }}"
                                                alt="Profile" id="avatar-preview" class="rounded"
                                                style="max-width: 200px;">

                                            <div class="pt-2">
                                                <input type="file" name="avatar" id="avatar" accept="image/*"
                                                    class="d-none" onchange="previewAvatar(event)">

                                                <button type="button" class="btn btn-primary btn-sm"
                                                    title="Upload new profile image"
                                                    onclick="document.getElementById('avatar').click()">
                                                    <i class="bi bi-upload"></i>
                                                </button>

                                                @if ($user->avatar)
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        title="Remove my profile image" onclick="removeAvatar()">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <a href="{{ route('profile.download-avatar', $user->id) }}"
                                                        class="btn btn-success btn-sm" title="Download profile image">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                @endif
                                            </div>

                                            <input type="hidden" name="remove_avatar" id="remove_avatar"
                                                value="0">

                                            @error('avatar')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('First Name') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="firstname" type="text" class="form-control" id="firstname"
                                                value="{{ $user->firstname }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Last Name') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="lastname" type="text" class="form-control" id="lastname"
                                                value="{{ $user->lastname }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="about"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('About') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="about" class="form-control" id="about" style="height: 100px">{{ $user->profile->about }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="company"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Company') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="company" type="text" class="form-control" id="company"
                                                value="{{ $user->profile->company }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Job"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Job') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" id="Job" name="job"
                                                value="{{ $user->profile->job }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Country"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Country') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" id="Country" name="country"
                                                value="{{ $user->profile->country }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Address"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Address') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" id="Address" name="address"
                                                value="{{ $user->profile->address }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="phone_display"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Phone') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="tel"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                id="phone_display"
                                                value="{{ old('phone', $user->profile->phone ?? '') }}">

                                            <input type="hidden" name="phone" id="phone_value">

                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="website"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Website') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text"
                                                class="form-control @error('website') is-invalid @enderror" id="website"
                                                name="website" placeholder="https://example.com" pattern="https?://.+"
                                                value="{{ old('website', $user->profile->website ?? '') }}">
                                            @error('website')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="twitter"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Twitter Profile') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="input-group">
                                                <span class="input-group-text" id="twitter">https://x.com/</span>
                                                <input type="text" class="form-control" id="twitter" name="twitter"
                                                    value="{{ $user->profile->twitter }}"
                                                    aria-describedby="twitter-profile">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Facebook"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Facebook Profile') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="input-group">
                                                <span class="input-group-text" id="facebook">https://facebook.com/</span>
                                                <input type="text" class="form-control" id="facebook"
                                                    name="facebook" value="{{ $user->profile->facebook }}"
                                                    aria-describedby="facebook-profile">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Instagram"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Instagram Profile') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    id="instagram">https://instagram.com/</span>
                                                <input type="text" class="form-control" id="instagram"
                                                    name="instagram" value="{{ $user->profile->instagram }}"
                                                    aria-describedby="instagram-profile">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Linkedin"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Linkedin Profile') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    id="linkedin">https://www.linkedin.com/in/</span>
                                                <input type="text" class="form-control" id="linkedin"
                                                    name="linkedin" value="{{ $user->profile->linkedin }}"
                                                    aria-describedby="linkedin-profile">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-settings">
                                <!-- Settings Form -->
                                <form>

                                    <div class="row mb-3">
                                        <label for="fullName"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Email Notifications') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                                <label class="form-check-label" for="changesMade">
                                                    Changes made to your account
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                                <label class="form-check-label" for="newProducts">
                                                    Information on new products and services
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="proOffers">
                                                <label class="form-check-label" for="proOffers">
                                                    Marketing and promo offers
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="securityNotify"
                                                    checked disabled>
                                                <label class="form-check-label" for="securityNotify">
                                                    Security alerts
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End settings Form -->
                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form>

                                    <div class="row mb-3">
                                        <label for="currentPassword"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Current Password') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control"
                                                id="currentPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('New Password') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control"
                                                id="newPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword"
                                            class="col-md-4 col-lg-3 col-form-label">{{ __('Re-enter New Password') }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renewpassword" type="password" class="form-control"
                                                id="renewPassword">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-primary">{{ __('Change Password') }}</button>
                                    </div>
                                </form><!-- End Change Password Form -->
                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/intl-tel-input/js/intlTelInput.min.js') }}"></script>

    <script>
        const phoneDisplay = document.querySelector("#phone_display");
        const phoneValue = document.querySelector("#phone_value");
        const form = phoneDisplay.closest('form');

        const iti = window.intlTelInput(phoneDisplay, {
            initialCountry: "ar",
            separateDialCode: true,
            preferredCountries: ["ar", "us", "mx", "es", "br", "cl", "co", "pe"]
        });

        // Función para actualizar el valor hidden
        function syncPhoneValue() {
            const number = phoneDisplay.value.trim();

            if (number) {
                const countryData = iti.getSelectedCountryData();
                const cleanNumber = number.replace(/\D/g, '');
                phoneValue.value = '+' + countryData.dialCode + cleanNumber;
            } else {
                phoneValue.value = '';
            }

            console.log('Phone value synced:', phoneValue.value);
        }

        // Sincronizar en diferentes eventos
        phoneDisplay.addEventListener('blur', syncPhoneValue);
        phoneDisplay.addEventListener('countrychange', syncPhoneValue);

        // CRÍTICO: Sincronizar justo antes de enviar
        form.addEventListener('submit', function(e) {
            syncPhoneValue();
            console.log('Enviando phone:', phoneValue.value);
            // No preventDefault, dejamos que se envíe normal
        });
    </script>


    <script>
        document.getElementById('website').addEventListener('blur', function() {
            let url = this.value.trim();

            if (url && !url.match(/^https?:\/\//i)) {
                this.value = 'https://' + url;
            }
        });
    </script>

    <script>
        function previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        function removeAvatar() {
            if (confirm('¿Estás seguro de eliminar tu foto de perfil?')) {
                document.getElementById('remove_avatar').value = '1';
                document.getElementById('avatar-preview').src = "{{ asset('assets/img/profile-img.jpg') }}";
                document.getElementById('avatar').value = '';
            }
        }
    </script>
@endpush
