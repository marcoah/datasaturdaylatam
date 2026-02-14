@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" rel="stylesheet">
    <style type="text/css">
        #map {
            height: 600px;
            width: 100%;
        }

        .custom-marker {
            background: transparent;
            border: none;
        }

        .legend {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
        }

        .legend h6 {
            margin: 0 0 10px 0;
            font-weight: bold;
        }

        .legend-item {
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Contenido Central -->
            <main role="main" class="col-12 px-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>
                        <i class="fas fa-map"></i>
                        Mapa de la Capa
                        @if ($objetos->first())
                            <small class="text-muted">{{ $objetos->first()->capa->nombre }}</small>
                        @endif
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group">
                            @if ($objetos->first())
                                <a class="btn btn-success"
                                    href="{{ route('capas.objetos.index', $objetos->first()->capa_id) }}">
                                    <i class="fas fa-list"></i> Ver Objetos
                                </a>
                            @endif
                            <a class="btn btn-primary" href="{{ route('capas.index') }}">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>

                @if ($objetos->isEmpty())
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        No hay objetos en esta capa para mostrar en el mapa.
                    </div>
                @else
                    <div class="row">
                        <div class="col-12">
                            <div id="map"></div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6><i class="fas fa-info-circle"></i> Información</h6>
                                    <p class="mb-0">
                                        <strong>Total de objetos:</strong> {{ $objetos->count() }} |
                                        <strong>Puntos:</strong> {{ $objetos->where('tipo', 'POINT')->count() }} |
                                        <strong>Líneas:</strong> {{ $objetos->where('tipo', 'LINESTRING')->count() }} |
                                        <strong>Polígonos:</strong> {{ $objetos->where('tipo', 'POLYGON')->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </main>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const objetos = @json($objetos);

            console.log('Objetos cargados:', objetos);

            // Inicializar mapa con coordenadas desde config
            const map = L.map('map', {
                zoomControl: true,
                scrollWheelZoom: true
            }).setView([{{ config('map.center_latitude') }}, {{ config('map.center_longitude') }}],
                {{ config('map.default_zoom') }});

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            const geometriesLayer = L.layerGroup().addTo(map);
            const allBounds = [];

            // Obtener color de la capa (del primer objeto)
            const capaColor = objetos.length > 0 && objetos[0].capa ? objetos[0].capa.color : '#3388ff';

            objetos.forEach((objeto, index) => {
                if (!objeto.geometria) {
                    console.warn(`Objeto ${index} sin geometría`, objeto);
                    return;
                }

                const nombre = objeto.nombre || 'Sin nombre';
                const tipo = objeto.tipo || 'POINT';
                const icono = objeto.icono || 'fa-map-pin';
                const geometria = objeto.geometria;

                console.log(`Procesando: ${nombre} (${tipo})`, geometria);

                // Crear popup
                const popupContent = `
                    <div style="min-width: 200px">
                        <h6 class="mb-1">
                            <i class="fas ${icono}"></i> ${nombre}
                        </h6>
                        <hr class="my-1">
                        <small>
                            <strong>ID:</strong> ${objeto.id}<br>
                            <strong>Tipo:</strong> ${tipo}<br>
                            ${objeto.observaciones ? `<strong>Observaciones:</strong> ${objeto.observaciones}` : ''}
                        </small>
                        <div class="mt-2">
                            <a href="/objetos/${objeto.id}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Ver detalles
                            </a>
                        </div>
                    </div>
                `;

                try {
                    // Crear capa GeoJSON
                    const geojsonLayer = L.geoJSON(geometria, {
                        style: function(feature) {
                            return {
                                color: capaColor,
                                weight: 3,
                                opacity: 0.8,
                                fillColor: capaColor,
                                fillOpacity: 0.3
                            };
                        },
                        pointToLayer: function(feature, latlng) {
                            return L.marker(latlng, {
                                icon: L.divIcon({
                                    html: `<i class="fas ${icono} fa-2x" style="color: ${capaColor}"></i>`,
                                    iconSize: [30, 30],
                                    className: 'custom-marker'
                                })
                            });
                        },
                        onEachFeature: function(feature, layer) {
                            layer.bindPopup(popupContent);
                            layer.bindTooltip(nombre, {
                                direction: 'top',
                                offset: [0, -10],
                                opacity: 0.9
                            });

                            // Click para centrar
                            layer.on('click', function() {
                                const bounds = layer.getBounds ? layer.getBounds() : L
                                    .latLngBounds([layer.getLatLng()]);
                                map.fitBounds(bounds, {
                                    padding: [50, 50],
                                    maxZoom: 16
                                });
                            });
                        }
                    });

                    geometriesLayer.addLayer(geojsonLayer);

                    // Guardar bounds
                    const bounds = geojsonLayer.getBounds();
                    allBounds.push(bounds);

                } catch (error) {
                    console.error(`Error procesando geometría de ${nombre}:`, error);
                }
            });

            // 🎯 Ajustar vista a todos los objetos
            if (allBounds.length > 0) {
                const combinedBounds = allBounds.reduce((acc, bound) => {
                    return acc ? acc.extend(bound) : bound;
                });

                map.fitBounds(combinedBounds, {
                    padding: [50, 50]
                });
            } else {
                console.warn('No se pudieron cargar geometrías');
            }

            // Agregar escala
            L.control.scale().addTo(map);

            console.log('Mapa inicializado correctamente');
        });
    </script>
@endpush
