@extends('layouts.escritorio')

@section('styles')
    <!-- Leaflet CSS -->
    <link href="{{ asset('assets/vendor/leaflet/leaflet.css') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        #map {
            height: 80vh;
            width: 100%;
            border-top: 1px solid #ddd;
        }

        .upload-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            padding: 10px;
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }

        button {
            padding: 6px 12px;
            background-color: #0078ff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        select,
        input[type="file"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="upload-container">
        <label for="geojsonFile">📁 Cargar GeoJSON:</label>
        <input type="file" id="geojsonFile" accept=".geojson,.json" />

        <label for="capaSelect">🗂️ Capa destino:</label>
        <select id="capaSelect">
            <option value="">Seleccione una capa</option>
            @foreach ($capas as $capa)
                <option value="{{ $capa->id }}">{{ $capa->nombre }}</option>
            @endforeach
        </select>

        <button id="btnGuardar" disabled>💾 Guardar en capa</button>
    </div>

    <div id="map"></div>
@endsection

@push('scripts')
    <!-- Leaflet JS -->
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>

    <script>
        let map = L.map('map').setView([10.24, -67.60], 12);
        let layerGeoJSON = null;
        let geojsonData = null;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // 📂 Cargar archivo
        document.getElementById('geojsonFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const geojson = JSON.parse(e.target.result);
                    geojsonData = geojson;

                    // Limpiar capa anterior
                    if (layerGeoJSON) map.removeLayer(layerGeoJSON);

                    // Agregar capa al mapa
                    layerGeoJSON = L.geoJSON(geojson, {
                        onEachFeature: function(feature, layer) {
                            let popup = "";
                            if (feature.properties) {
                                for (let key in feature.properties) {
                                    popup +=
                                        `<strong>${key}:</strong> ${feature.properties[key]}<br>`;
                                }
                            }
                            layer.bindPopup(popup);
                        },
                        style: {
                            color: "#0078ff",
                            weight: 2
                        },
                        pointToLayer: (f, latlng) => L.marker(latlng)
                    }).addTo(map);

                    map.fitBounds(layerGeoJSON.getBounds());
                    document.getElementById('btnGuardar').disabled = false;

                } catch (err) {
                    alert("❌ El archivo no es un GeoJSON válido.");
                    console.error(err);
                }
            };

            reader.readAsText(file);
        });

        // 💾 Guardar en capa
        document.getElementById('btnGuardar').addEventListener('click', function() {
            const capaId = document.getElementById('capaSelect').value;
            if (!capaId) {
                alert("Seleccione una capa antes de guardar.");
                return;
            }
            if (!geojsonData) {
                alert("No hay datos cargados.");
                return;
            }

            axios.post(`/capas/${capaId}/importar-geojson`, {
                    geojson: geojsonData
                })
                .then(response => {
                    alert("✅ GeoJSON importado correctamente.");
                    console.log(response.data);
                })
                .catch(error => {
                    alert("⚠️ Error al guardar los datos.");
                    console.error(error);
                });
        });
    </script>
@endpush
