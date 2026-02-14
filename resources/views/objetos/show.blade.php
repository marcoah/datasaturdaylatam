@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" rel="stylesheet">

    <style>
        #mapid {
            height: 400px;
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
                    <h1>{{ $objeto->nombre }}</h1>
                    <div class="btn-toolbar mb-6 mb-md-0">
                        <div class="btn-group mr-6">
                            <a class="btn btn-primary" href="{{ route('objetos.edit', $objeto->id) }}">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a class="btn btn-success" href="{{ route('capas.objetos.index', $objeto->capa_id) }}">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas {{ $objeto->icono }}"></i>
                                Detalles del Objeto - Tipo: {{ $objeto->tipo }}
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Nombre:</strong>
                                        <p>{{ $objeto->nombre }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Tipo:</strong>
                                        <p><span class="badge bg-info">{{ $objeto->tipo }}</span></p>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Icono:</strong>
                                        <p><i class="fas {{ $objeto->icono }} fa-2x"></i> {{ $objeto->icono }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <strong>Capa:</strong>
                                        <p>
                                            <a href="{{ route('capas.show', $objeto->capa_id) }}">
                                                {{ $objeto->capa->nombre }}
                                            </a>
                                            <span class="badge" style="background-color: {{ $objeto->capa->color }}">
                                                {{ $objeto->capa->color }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if ($objeto->observaciones)
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <strong>Observaciones:</strong>
                                            <p>{{ $objeto->observaciones }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($objeto->geometria)
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <strong>Geometría (WKT):</strong>
                                            <p><code>{{ $objeto->geometria }}</code></p>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($objeto->geometria)
                                            <div id="mapid"></div>
                                        @else
                                            <div class="alert alert-warning">Este objeto no tiene geometría definida.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                Creado: {{ $objeto->created_at->format('d/m/Y H:i') }} |
                                Actualizado: {{ $objeto->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>

    <script>
        $(document).ready(function() {
            @if ($objeto->geometria)
                // Obtener el GeoJSON del objeto
                @if ($objeto->tipo === 'POINT')
                    var lat = {{ $objeto->geometria->getLatitude() }};
                    var lng = {{ $objeto->geometria->getLongitude() }};
                    var geojson = {
                        type: "Point",
                        coordinates: [lng, lat]
                    };
                @else
                    var geojson = {!! json_encode($objeto->geometria->toGeoJsonArray()) !!};
                @endif

                console.log('GeoJSON:', geojson);

                // Inicializar el mapa
                // Inicializar el mapa con centro por defecto
                var map = L.map('mapid').setView([{{ config('map.center_latitude') }},
                    {{ config('map.center_longitude') }}
                ], {{ config('map.default_zoom') }});


                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Crear capa para la geometría
                var geojsonLayer = L.geoJSON(geojson, {
                    style: function(feature) {
                        return {
                            color: '{{ $objeto->capa->color }}',
                            weight: 3,
                            opacity: 0.8
                        };
                    },
                    pointToLayer: function(feature, latlng) {
                        return L.marker(latlng, {
                            icon: L.divIcon({
                                html: '<i class="fas {{ $objeto->icono }} fa-2x" style="color: {{ $objeto->capa->color }}"></i>',
                                iconSize: [30, 30],
                                className: 'custom-marker'
                            })
                        });
                    },
                    onEachFeature: function(feature, layer) {
                        layer.bindPopup(
                            '<strong>{{ $objeto->nombre }}</strong><br>Tipo: {{ $objeto->tipo }}');
                    }
                }).addTo(map);

                // Ajustar el mapa a la geometría
                map.fitBounds(geojsonLayer.getBounds());
            @endif
        });
    </script>

    <style>
        .custom-marker {
            background: transparent;
            border: none;
        }
    </style>
@endpush
