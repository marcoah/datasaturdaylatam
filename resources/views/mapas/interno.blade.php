@extends('layouts.escritorio')

@section('styles')
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #mapid {
            width: 100%;
            height: 320px;
            position: relative;
            outline: none;
        }

        @media (min-width: 768px) {
            #mapid {
                height: 480px;
            }
        }

        @media (min-width: 992px) {
            #mapid {
                height: 640px;
            }
        }

        @media (min-width: 1200px) {
            #mapid {
                height: 520px;
            }
        }

        @media (min-width: 1800px) {
            #mapid {
                height: 798px;
            }
        }

        .custom-marker {
            background: transparent;
            border: none;
        }
    </style>
@endsection

@section('content')
    <div class="container">

        {{-- TOOLBAR --}}
        <div class="row mb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body py-2">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <label class="mb-0 fw-bold">Capas:</label>

                            <select id="proyecto" class="form-control form-control-sm" style="max-width: 260px"
                                onchange="cargarProyecto()">
                                <option value="" selected disabled hidden>
                                    Seleccionar
                                </option>
                                @foreach ($capas as $capa)
                                    <option value="{{ $capa->id }}" data-color="{{ $capa->color }}">
                                        {{ $capa->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            <button id="clearLayers" class="btn btn-sm btn-warning" onclick="limpiarCapas()">
                                <i class="fas fa-eraser"></i> Limpiar
                            </button>

                            {{-- futuros filtros aquí --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAPA --}}
        <div class="row">
            <div class="col-12">
                <div id="mapid"></div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- Dependencias --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // =========================
        // INICIALIZACIÓN DEL MAPA
        // =========================

        const map = L.map('mapid', {
            zoomControl: true
        }).setView([{{ config('map.center_latitude') }}, {{ config('map.center_longitude') }}],
            {{ config('map.default_zoom') }});

        const geometriesLayer = L.layerGroup().addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.control.scale().addTo(map);

        // 🔑 CLAVE: esperar a que Leaflet esté listo
        map.whenReady(() => {
            map.invalidateSize();
        });

        // =========================
        // FUNCIONES AUXILIARES
        // =========================

        function limpiarCapas() {
            geometriesLayer.clearLayers();
            document.getElementById('proyecto').value = '';
        }

        // =========================
        // CARGA DE PROYECTO/CAPA
        // =========================

        function cargarProyecto() {
            const select = document.getElementById('proyecto');
            const idproyecto = select.value;
            const selectedOption = select.options[select.selectedIndex];
            const capaColor = selectedOption.dataset.color || '#3388ff';

            if (!idproyecto) {
                console.warn('No hay proyecto seleccionado');
                return;
            }

            const url = `/datosproyecto/${idproyecto}`;

            console.log('Cargando capa:', idproyecto);

            axios.get(url)
                .then(response => {

                    // 🔍 Normalizar data (array o {data: []})
                    let items = response.data;

                    if (items && typeof items === 'object' && Array.isArray(items.data)) {
                        items = items.data;
                    }

                    if (!Array.isArray(items)) {
                        console.error('La respuesta NO es un array:', response.data);
                        return;
                    }

                    // 🧹 Limpiar capa
                    geometriesLayer.clearLayers();

                    const bounds = [];

                    items.forEach((item, index) => {
                        if (!item || !item.geometria) {
                            console.warn(`Objeto ${index} sin geometría`, item);
                            return;
                        }

                        const id = item.id ?? 'N/A';
                        const nombre = item.nombre ?? 'Sin nombre';
                        const tipo = item.tipo ?? 'POINT';
                        const icono = item.icono ?? 'fa-map-pin';
                        const geometria = item.geometria;

                        console.log(`Procesando ${nombre} (${tipo}):`, geometria);

                        // Crear popup HTML
                        const popupContent = `
                            <div style="min-width: 220px">
                                <h6 class="mb-1">
                                    <i class="fas ${icono}"></i> ${nombre}
                                </h6>
                                <hr class="my-1">
                                <small>
                                    <strong>ID:</strong> ${id}<br>
                                    <strong>Tipo:</strong> ${tipo}<br>
                                    <strong>Icono:</strong> ${icono}
                                </small>
                            </div>
                        `;

                        // Crear capa según el tipo de geometría
                        try {
                            const geojsonLayer = L.geoJSON(geometria, {
                                style: function(feature) {
                                    return {
                                        color: capaColor,
                                        weight: 3,
                                        opacity: 0.8,
                                        fillOpacity: 0.3
                                    };
                                },
                                pointToLayer: function(feature, latlng) {
                                    // Para puntos, usar icono personalizado
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

                                    // Click handler
                                    layer.on('click', function() {
                                        const layerBounds = layer.getBounds ? layer
                                            .getBounds() : L.latLngBounds([layer
                                                .getLatLng()
                                            ]);
                                        map.fitBounds(layerBounds, {
                                            padding: [50, 50],
                                            maxZoom: 16
                                        });
                                    });
                                }
                            });

                            geometriesLayer.addLayer(geojsonLayer);

                            // Agregar bounds
                            const layerBounds = geojsonLayer.getBounds();
                            bounds.push(layerBounds);

                        } catch (error) {
                            console.error(`Error procesando geometría de ${nombre}:`, error, geometria);
                        }
                    });

                    // 🎯 Ajustar mapa a todas las geometrías
                    if (bounds.length) {
                        // Combinar todos los bounds
                        const combinedBounds = bounds.reduce((acc, bound) => {
                            return acc ? acc.extend(bound) : bound;
                        });

                        map.fitBounds(combinedBounds, {
                            padding: [30, 30]
                        });
                        map.invalidateSize();
                    } else {
                        console.warn('No se agregaron geometrías');
                    }
                })
                .catch(error => {
                    console.error('Error cargando el proyecto:', error);
                    alert('Error al cargar los datos de la capa');
                });
        }
    </script>
@endpush
