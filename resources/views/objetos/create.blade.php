@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"
        integrity="sha512-gc3xjCmIy673V6MyOAZhIW93xhM9ei1I+gLbmFjUHIjocENRsLX/QUE1htk5q1XV2D/iie/VQ8DXI6Vu8bexvQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        #mapid {
            height: 500px;
            width: 100%;
            z-index: 1;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Crear objeto</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('capas.index') }}">Capas</a></li>
                <li class="breadcrumb-item active">Crear punto</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">

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
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="POST" action="{{ route('capas.objetos.store', ['capa' => $datoscapa->id]) }}"
                        accept-charset="UTF-8">
                        @csrf
                        <div class="card-body">

                            <h5 class="card-title">Nuevo objeto</h5>

                            <div class="row mb-3">
                                <label for="nombre" class="col-sm-2 col-form-label">Nombre del objeto</label>
                                <div class="col-sm-4">
                                    <input id="nombre" type="text" class="form-control" name="nombre"
                                        value="{{ old('nombre') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="capa_id" class="col-sm-2 col-form-label">Capa</label>
                                <div class="col-sm-4">
                                    <select class="form-select" id="capa_id" name="capa_id">
                                        <option value="{{ $datoscapa->id }}" selected>{{ $datoscapa->nombre }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="icono" class="col-sm-2 col-form-label">Icono</label>
                                <div class="col-sm-4">
                                    <select id="iconSelect" class="form-select icon-select" name="icono">
                                        <option value="fa-map-pin" data-icon="fa-solid fa-map-pin">fa-map-pin
                                        </option>
                                        <option value="fa-map-marker-alt" data-icon="fas fa-map-marker-alt">
                                            fa-map-marker-alt
                                        </option>
                                        <option value="fa-home" data-icon="fas fa-home">fa-home</option>
                                        <option value="fa-store" data-icon="fas fa-store">fa-store</option>
                                        <option value="fa-flag" data-icon="fas fa-flag">fa-flag</option>
                                        <option value="fa-tree" data-icon="fas fa-tree">fa-tree</option>
                                        <option value="fa-map-marker" data-icon="fas fa-map-marker">fa-map-marker
                                        </option>
                                        <option value="fa-circle" data-icon="fas fa-circle">fa-circle</option>
                                        <option value="fa-fire-alt" data-icon="fas fa-fire-alt">fa-fire-alt
                                        </option>
                                        <option value="fa-tint" data-icon="fas fa-tint">fa-tint</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tipo" class="col-sm-2 col-form-label">Tipo de objeto</label>
                                <div class="col-sm-4">
                                    <select id="typeSelect" class="form-select" name="tipo">
                                        <option value="POINT" selected>POINT</option>
                                        <option value="LINESTRING">LINESTRING</option>
                                        <option value="POLYGON">POLYGON</option>
                                        <option value="MULTIPOINT">MULTIPOINT</option>
                                        <option value="MULTILINESTRING">MULTILINESTRING</option>
                                        <option value="MULTIPOLYGON">MULTIPOLYGON</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" id="clearGeometry" class="btn btn-warning btn-sm">
                                        <i class="fas fa-eraser"></i> Limpiar geometría
                                    </button>
                                </div>
                            </div>

                            <!-- Campo hidden para guardar la geometría -->
                            <input type="hidden" id="geometria" name="geometria">

                            <!-- Los campos lat/lng solo para POINT -->
                            <div class="row mb-3" id="coordsInputs">
                                <label for="latitud" class="col-sm-2 col-form-label">Latitud</label>
                                <div class="col-sm-4">
                                    <input id="latitud" type="text" class="form-control" name="latitud"
                                        value="{{ old('latitud', request('latitud')) }}">
                                </div>

                                <label for="longitud" class="col-sm-2 col-form-label">Longitud</label>
                                <div class="col-md-4">
                                    <input id="longitud" type="text" class="form-control" name="longitud"
                                        value="{{ old('longitud', request('longitud')) }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="alert alert-info" id="drawInstructions">
                                        <i class="fas fa-info-circle"></i>
                                        <span id="instructionText">Haz clic en el mapa para colocar un punto</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="mapid" style="height: 500px;"></div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Crear</button>
                            <a href="{{ route('capas.objetos.index', ['capa' => $datoscapa->id]) }}"
                                class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

    {{--
    <script>
        // Inicializar Select2 primero
        $('#iconSelect').select2({
            templateResult: formatIcon,
            templateSelection: formatIcon
        });

        function formatIcon(icon) {
            if (!icon.id) return icon.text;

            const iconClass = $(icon.element).data('icon');
            return $('<span><i class="' + iconClass + '"></i> ' + icon.text + '</span>');
        }
    </script>
    --}}



    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
    <!-- Leaflet Draw más reciente desde GitHub -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"
        integrity="sha512-gc3xjCmIy673V6MyOAZhIW93xhM9ei1I+gLbmFjUHIjocENRsLX/QUE1htk5q1XV2D/iie/VQ8DXI6Vu8bexvQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"
        integrity="sha512-ozq8xQKq6urvuU6jNgkfqAmT7jKN2XumbrX1JiB3TnF7tI48DPI4Gy1GXKD/V3EExgAs1V+pRO7vwtS1LHg0Gw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {

            // Inicializar Select2 solo para iconos
            //$('#iconSelect').select2();

            // MAPA

            var mapCenter = [{{ config('map.center_latitude') }}, {{ config('map.center_longitude') }}];
            var map = L.map('mapid').setView(mapCenter, {{ config('map.default_zoom') }});

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Variables para manejar las geometrías
            var drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            var drawControl = null;
            var currentType = 'POINT';

            // Instrucciones para cada tipo
            var instructions = {
                'POINT': 'Haz clic en el mapa para colocar un punto',
                'LINESTRING': 'Haz clic para agregar puntos a la línea. Doble clic para terminar',
                'POLYGON': 'Haz clic para agregar vértices al polígono. Cierra haciendo clic en el primer punto',
                'MULTIPOINT': 'Haz clic en el mapa para agregar múltiples puntos',
                'MULTILINESTRING': 'Dibuja múltiples líneas. Doble clic para terminar cada línea',
                'MULTIPOLYGON': 'Dibuja múltiples polígonos'
            };

            // Configurar controles de dibujo según el tipo
            function setupDrawControls(type) {
                console.log('Setup draw controls:', type);

                // Remover control anterior
                if (drawControl) {
                    map.removeControl(drawControl);
                }

                currentType = type;
                $('#instructionText').text(instructions[type]);

                var drawOptions = {
                    position: 'topright',
                    draw: {
                        polyline: false,
                        polygon: false,
                        circle: false,
                        rectangle: false,
                        marker: false,
                        circlemarker: false
                    },
                    edit: {
                        featureGroup: drawnItems,
                        remove: true
                    }
                };

                // Activar el tipo de dibujo correspondiente
                switch (type) {
                    case 'POINT':
                        drawOptions.draw.marker = true;
                        break;
                    case 'LINESTRING':
                    case 'MULTILINESTRING':
                        drawOptions.draw.polyline = {
                            shapeOptions: {
                                color: '#f357a1',
                                weight: 4
                            }
                        };
                        break;
                    case 'POLYGON':
                    case 'MULTIPOLYGON':
                        drawOptions.draw.polygon = {
                            shapeOptions: {
                                color: '#3388ff'
                            }
                        };
                        break;
                    case 'MULTIPOINT':
                        drawOptions.draw.marker = true;
                        break;
                }

                drawControl = new L.Control.Draw(drawOptions);
                map.addControl(drawControl);
            }

            // Convertir capa a WKT para PostgreSQL
            function layerToWKT(layer) {
                var coords;

                if (layer instanceof L.Marker) {
                    var latlng = layer.getLatLng();
                    return `POINT(${latlng.lng} ${latlng.lat})`;
                } else if (layer instanceof L.Polyline && !(layer instanceof L.Polygon)) {
                    coords = layer.getLatLngs().map(function(latlng) {
                        return `${latlng.lng} ${latlng.lat}`;
                    }).join(',');
                    return `LINESTRING(${coords})`;
                } else if (layer instanceof L.Polygon) {
                    coords = layer.getLatLngs()[0].map(function(latlng) {
                        return `${latlng.lng} ${latlng.lat}`;
                    });
                    // Cerrar el polígono
                    var first = layer.getLatLngs()[0][0];
                    coords.push(`${first.lng} ${first.lat}`);
                    return `POLYGON((${coords.join(',')}))`;
                }

                return null;
            }

            // Actualizar el campo geometria con WKT
            function updateGeometriaField() {
                var layers = drawnItems.getLayers();

                if (layers.length === 0) {
                    $('#geometria').val('');
                    return;
                }

                if (layers.length === 1 && ['POINT', 'LINESTRING', 'POLYGON'].includes(currentType)) {
                    var wkt = layerToWKT(layers[0]);
                    $('#geometria').val(wkt);
                    console.log('Geometría guardada:', wkt);
                } else if (currentType === 'MULTIPOINT') {
                    var points = layers.map(function(layer) {
                        var latlng = layer.getLatLng();
                        return `${latlng.lng} ${latlng.lat}`;
                    }).join(',');
                    $('#geometria').val(`MULTIPOINT((${points}))`);
                } else if (currentType === 'MULTILINESTRING') {
                    var lines = layers.map(function(layer) {
                        var coords = layer.getLatLngs().map(function(latlng) {
                            return `${latlng.lng} ${latlng.lat}`;
                        }).join(',');
                        return `(${coords})`;
                    }).join(',');
                    $('#geometria').val(`MULTILINESTRING(${lines})`);
                } else if (currentType === 'MULTIPOLYGON') {
                    var polygons = layers.map(function(layer) {
                        var coords = layer.getLatLngs()[0].map(function(latlng) {
                            return `${latlng.lng} ${latlng.lat}`;
                        });
                        var first = layer.getLatLngs()[0][0];
                        coords.push(`${first.lng} ${first.lat}`);
                        return `((${coords.join(',')}))`;
                    }).join(',');
                    $('#geometria').val(`MULTIPOLYGON(${polygons})`);
                }
            }

            // Evento cuando se crea una geometría
            map.on(L.Draw.Event.CREATED, function(e) {
                console.log('Geometría creada:', e.layerType);
                var layer = e.layer;

                // Para tipos simples, reemplazar la geometría anterior
                if (['POINT', 'LINESTRING', 'POLYGON'].includes(currentType)) {
                    drawnItems.clearLayers();
                }

                drawnItems.addLayer(layer);

                // Actualizar campo hidden con WKT
                updateGeometriaField();

                // Si es POINT, actualizar también los campos de lat/lng
                if (currentType === 'POINT' && layer instanceof L.Marker) {
                    var latlng = layer.getLatLng();
                    $('#latitud').val(latlng.lat.toString().substring(0, 15));
                    $('#longitud').val(latlng.lng.toString().substring(0, 15));
                }
            });

            // Evento cuando se edita una geometría
            map.on(L.Draw.Event.EDITED, function(e) {
                console.log('Geometría editada');
                updateGeometriaField();
            });

            // Evento cuando se elimina una geometría
            map.on(L.Draw.Event.DELETED, function(e) {
                console.log('Geometría eliminada');
                updateGeometriaField();
                if (currentType === 'POINT') {
                    $('#latitud').val('');
                    $('#longitud').val('');
                }
            });

            // Cambio de tipo de geometría - SELECT NORMAL
            document.getElementById('typeSelect').addEventListener('change', function() {
                var newType = this.value;
                console.log('Tipo cambiado a:', newType);

                // Limpiar geometrías existentes
                drawnItems.clearLayers();
                $('#geometria').val('');
                $('#latitud').val('');
                $('#longitud').val('');

                // Mostrar/ocultar campos de coordenadas
                if (newType === 'POINT') {
                    $('#coordsInputs').show();
                } else {
                    $('#coordsInputs').hide();
                }

                // Reconfigurar controles
                setupDrawControls(newType);
            });

            // Botón para limpiar geometría
            $('#clearGeometry').on('click', function() {
                drawnItems.clearLayers();
                $('#geometria').val('');
                $('#latitud').val('');
                $('#longitud').val('');
            });

            // Actualizar punto desde inputs de lat/lng (solo para POINT)
            function updateMarkerFromInputs() {
                if (currentType !== 'POINT') return;

                var lat = parseFloat($('#latitud').val());
                var lng = parseFloat($('#longitud').val());

                if (!isNaN(lat) && !isNaN(lng)) {
                    drawnItems.clearLayers();
                    var marker = L.marker([lat, lng]).addTo(drawnItems);
                    map.setView([lat, lng], map.getZoom());
                    updateGeometriaField();
                }
            }

            $('#latitud, #longitud').on('input', updateMarkerFromInputs);

            // Inicializar con POINT por defecto
            setupDrawControls('POINT');

            console.log('Mapa inicializado correctamente');
        });
    </script>
@endpush
