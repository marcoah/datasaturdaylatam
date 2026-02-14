@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" rel="stylesheet">


    <style>
        #mapid {
            height: 300px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">

            <!-- Contenido Central -->
            <main role="main" class="col-lg-12 col-sm-12 col-md-12 ml-sm-auto px-4">
                <div id="app"></div>
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 col-sm-12 border-bottom">
                    <h1>Editar objeto</h1>
                    <div class="btn-toolbar mb-6 mb-md-0">
                        <div class="btn-group mr-6">
                            <a class="btn btn-success"
                                href=" {{ route('capas.objetos.index', ['capa' => $objeto->capa_id]) }}"> Volver</a>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">Editar Punto</div>
                            <form action="{{ route('objetos.update', $objeto->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nombre" class="control-label">Nombre</label>
                                        <input id="nombre" type="text"
                                            class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"
                                            name="nombre" value="{{ $objeto->nombre }}" required>
                                        {!! $errors->first('nombre', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="capa_id" class="control-label">capa_id</label>
                                                <input id="capa_id"
                                                    class="form-control{{ $errors->has('capa_id') ? ' is-invalid' : '' }}"
                                                    type="text" name="capa_id" value="{{ $objeto->capa_id }}" required
                                                    readOnly>
                                                {!! $errors->first('capa_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipo" class="control-label">tipo</label>
                                                <input id="tipo"
                                                    class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}"
                                                    type="text" name="tipo" value="{{ $objeto->tipo }}">
                                                {!! $errors->first('tipo', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="icono" class="control-label">icono</label>
                                                <input id="icono"
                                                    class="form-control{{ $errors->has('icono') ? ' is-invalid' : '' }}"
                                                    type="text" name="icono" value="{{ $objeto->icono }}">
                                                {!! $errors->first('icono', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="archivo" class="control-label">archivo</label>
                                                <input id="archivo"
                                                    class="form-control{{ $errors->has('archivo') ? ' is-invalid' : '' }}"
                                                    type="text" name="archivo" value="{{ $objeto->archivo }}">
                                                {!! $errors->first('archivo', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="origen" class="control-label">origen</label>
                                                <select
                                                    class="form-control{{ $errors->has('origen') ? ' is-invalid' : '' }}"
                                                    id="origen" name="origen">
                                                    <option value="{{ $objeto->origen }}" selected readonly hidden>
                                                        {{ $objeto->origen }}</option>
                                                    <option value="Contribucion"> Contribucion</option>
                                                    <option value="Manual"> Manual</option>
                                                    <option value="Automatizado"> Automatizado</option>
                                                </select>
                                                {!! $errors->first('origen', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="fuente" class="control-label">fuente</label>
                                                <input id="fuente"
                                                    class="form-control{{ $errors->has('fuente') ? ' is-invalid' : '' }}"
                                                    type="text" name="fuente" value="{{ $objeto->fuente }}">
                                                {!! $errors->first('fuente', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="latitud" class="control-label">latitud</label>
                                                <input id="latitud" type="text"
                                                    class="form-control{{ $errors->has('latitud') ? ' is-invalid' : '' }}"
                                                    name="latitud" value="{{ $objeto->posicion->getLatitude() }}" readOnly>
                                                {!! $errors->first('latitud', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="longitud" class="control-label">longitud</label>
                                                <input id="longitud" type="text"
                                                    class="form-control{{ $errors->has('longitud') ? ' is-invalid' : '' }}"
                                                    name="longitud" value="{{ $objeto->posicion->getLongitude() }}"
                                                    readOnly>
                                                {!! $errors->first('longitud', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div id="mapid"></div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a href="{{ route('capas.objetos.index', ['capa' => $objeto->capa_id]) }}"
                                        class="btn btn-danger">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Leaflet JS -->
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>

    <script>
        var mapCenter = [$('#latitud').val(), $('#longitud').val()];
        var map = L.map('mapid').setView(mapCenter, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);

        function updateMarker(lat, lng) {
            marker
                .setLatLng([lat, lng])
                .bindPopup("Coordenada :  " + marker.getLatLng().toString())
                .openPopup();
            return false;
        };

        map.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);
            $('#latitud').val(latitude);
            $('#longitud').val(longitude);
            updateMarker(latitude, longitude);
        });

        var updateMarkerByInputs = function() {
            return updateMarker($('#latitud').val(), $('#longitud').val());
        }
        $('#latitud').on('input', updateMarkerByInputs);
        $('#longitud').on('input', updateMarkerByInputs);
    </script>
@endpush
