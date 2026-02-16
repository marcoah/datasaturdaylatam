@php
    // Determinar el layout según el rol del usuario
    $layout = 'layouts.escritorio'; // Default

    if (auth()->check()) {
        $userRole = auth()->user()->role;

        if ($userRole === 'ponente') {
            $layout = 'layouts.ponentes';
        } elseif ($userRole === 'asistente') {
            $layout = 'layouts.asistente';
        } elseif (in_array($userRole, ['admin', 'editor'])) {
            $layout = 'layouts.escritorio';
        }
    }
@endphp

@extends($layout)

@section('content')

    <div class="pagetitle">
        <h1>Mi Ponencia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Mi Ponencia</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <!-- Alerts -->
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

        @if ($ponencia)
            <div class="row">
                <div class="col-lg-10">
                    <!-- Información de la Ponencia -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title display-6 fw-bold">{{ $ponencia->titulo }}</h5>

                            <div class="alert alert-light border border-primary border-3 border-start mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong><i class="bi bi-calendar-event text-primary"></i> Fecha y
                                                Hora:</strong><br>
                                            {{ $ponencia->fecha_hora_ponencia }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong><i class="bi bi-star text-warning"></i> Nivel:</strong><br>
                                            {{ ucfirst($ponencia->nivel) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted">Descripción:</h6>
                                <p>{{ $ponencia->descripcion }}</p>
                            </div>

                            @if ($ponencia->aprobada)
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    Tu ponencia ha sido aprobada
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-clock me-2"></i>
                                    Tu ponencia está pendiente de aprobación
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Subir/Actualizar Archivo -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Material de la Ponencia</h5>

                            @if ($ponencia->archivo)
                                <div class="alert alert-info mb-4">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-file-earmark-check"></i> Archivo Actual
                                    </h6>
                                    <p class="mb-2">
                                        <strong>{{ basename($ponencia->archivo) }}</strong>
                                    </p>
                                    <a href="{{ asset('storage/' . $ponencia->archivo) }}" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Ver Archivo
                                    </a>
                                    <a href="{{ asset('storage/' . $ponencia->archivo) }}" download
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Descargar
                                    </a>
                                </div>
                            @endif

                            <form method="post" action="{{ route('ponencias.subir-archivo', $ponencia->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="row mb-3">
                                    <label for="archivo" class="col-sm-3 col-form-label">
                                        {{ $ponencia->archivo ? 'Actualizar Archivo' : 'Subir Archivo' }}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control @error('archivo') is-invalid @enderror"
                                            id="archivo" name="archivo" accept=".pdf,.pptx,.ppt" required>
                                        @error('archivo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Formatos permitidos: PDF, PPTX, PPT. Tamaño máximo: 10MB
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-upload"></i>
                                        {{ $ponencia->archivo ? 'Actualizar Archivo' : 'Subir Archivo' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning">
                        <h5 class="alert-heading">
                            <i class="bi bi-exclamation-triangle"></i> No tienes una ponencia asignada
                        </h5>
                        <p class="mb-0">Por favor, contacta al administrador para más información.</p>
                    </div>
                </div>
            </div>
        @endif
    </section>

@endsection
