@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>Importar Objetos desde Excel</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('capas.objetos.index', ['capa' => $capa->id]) }}">Objetos</a>
                </li>
                <li class="breadcrumb-item active">Importar</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ session('warning') }}</strong>
                        @if (session('errores'))
                            <ul class="mt-2 mb-0">
                                @foreach (session('errores') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ session('error') }}</strong>
                        @if (session('errores'))
                            <ul class="mt-2 mb-0">
                                @foreach (session('errores') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Importar Objetos</h5>

                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="bi bi-info-circle"></i> Formato del archivo Excel
                            </h6>
                            <p class="mb-2">El archivo debe contener las siguientes columnas obligatorias:</p>
                            <ul class="mb-2">
                                <li><strong>nombre</strong> - Nombre del objeto (obligatorio)</li>
                                <li><strong>latitud</strong> - Coordenada latitud (obligatorio, entre -90 y 90)</li>
                                <li><strong>longitud</strong> - Coordenada longitud (obligatorio, entre -180 y 180)</li>
                            </ul>
                            <p class="mb-2">Columnas opcionales:</p>
                            <ul class="mb-0">
                                <li><strong>icono</strong> - Clase del ícono (ej: fa-hotel, fa-restaurant)</li>
                                <li><strong>direccion</strong> - Dirección del objeto</li>
                                <li><strong>telefono</strong> - Teléfono de contacto</li>
                                <li><strong>email</strong> - Email de contacto</li>
                                <li><strong>url</strong> - Sitio web</li>
                                <li><strong>observaciones</strong> - Notas adicionales</li>
                                <li><strong>meta</strong> - Datos adicionales en formato JSON</li>
                            </ul>
                        </div>

                        <form method="post" action="{{ route('objetos.importar') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-4">
                                <label for="capa_id" class="col-sm-3 col-form-label">Capa de Destino</label>
                                <div class="col-sm-9">
                                    <select class="form-select @error('capa_id') is-invalid @enderror" id="capa_id"
                                        name="capa_id" required>
                                        <option value="{{ $capa->id }}" selected>
                                            {{ $capa->nombre }}
                                        </option>
                                    </select>
                                    @error('capa_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Todos los objetos se importarán a esta capa</div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label for="archivo_excel" class="col-sm-3 col-form-label">Archivo Excel</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control @error('archivo_excel') is-invalid @enderror"
                                        id="archivo_excel" name="archivo_excel" accept=".xlsx,.xls,.csv" required>
                                    @error('archivo_excel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Formatos permitidos: XLSX, XLS, CSV. Máximo 5MB</div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-upload"></i> Importar Objetos
                                </button>
                                <a class="btn btn-secondary btn-lg"
                                    href="{{ route('capas.objetos.index', ['capa' => $capa->id]) }}">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Ejemplo de estructura del Excel -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Ejemplo de Estructura del Excel</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>nombre</th>
                                        <th>latitud</th>
                                        <th>longitud</th>
                                        <th>icono</th>
                                        <th>direccion</th>
                                        <th>telefono</th>
                                        <th>email</th>
                                        <th>url</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Hotel Plaza</td>
                                        <td>-34.603722</td>
                                        <td>-58.381592</td>
                                        <td>fa-hotel</td>
                                        <td>Av. 9 de Julio 1234</td>
                                        <td>+54 11 1234-5678</td>
                                        <td>info@hotelplaza.com</td>
                                        <td>https://hotelplaza.com</td>
                                    </tr>
                                    <tr>
                                        <td>Restaurante El Buen Sabor</td>
                                        <td>-34.607474</td>
                                        <td>-58.382460</td>
                                        <td>fa-utensils</td>
                                        <td>Calle Florida 567</td>
                                        <td>+54 11 8765-4321</td>
                                        <td>contacto@buensabor.com</td>
                                        <td>https://buensabor.com</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
