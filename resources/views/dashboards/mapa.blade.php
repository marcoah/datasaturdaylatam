@php
    // Determinar el layout según el rol del usuario
    $layout = 'layouts.escritorio'; // Default

    if (auth()->check()) {
        $userRole = auth()->user()->role; // Ajusta según tu campo de rol

        if ($userRole === 'asistente') {
            $layout = 'layouts.asistente';
        } elseif (in_array($userRole, ['super-admin', 'admin', 'editor', 'ponente'])) {
            $layout = 'layouts.escritorio';
        }
    }
@endphp

@extends($layout)

@section('content')
    <div class="pagetitle">
        <h1>Mapa - {{ $capa->nombre }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Mapa de {{ $capa->nombre }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $capa->nombre }}</h5>

                        <!-- Controles del mapa -->
                        <div class="mb-3 d-flex gap-2 flex-wrap">
                            <button class="btn btn-sm btn-outline-primary" id="btn-zoom-in">
                                <i class="bi bi-zoom-in"></i> Acercar
                            </button>
                            <button class="btn btn-sm btn-outline-primary" id="btn-zoom-out">
                                <i class="bi bi-zoom-out"></i> Alejar
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" id="btn-reset">
                                <i class="bi bi-arrow-clockwise"></i> Resetear vista
                            </button>
                            <span class="badge bg-info align-self-center ms-auto">
                                {{ count($objetos) }} {{ Str::plural('objeto', count($objetos)) }} en la capa
                            </span>
                        </div>

                        <!-- Contenedor del mapa -->
                        <div id="mapa"
                            style="height: 600px; width: 100%; border: 1px solid #dee2e6; border-radius: 0.25rem;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de objetos -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Objetos en {{ $capa->nombre }}</h5>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($objetos as $objeto)
                                        <tr>
                                            <td>
                                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                                {{ $objeto->nombre }}
                                            </td>
                                            <td class="text-muted">{{ $objeto->direccion ?? 'N/A' }}</td>
                                            <td class="text-muted">{{ $objeto->telefono ?? 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="centrarMapa({{ $objeto->latitud }}, {{ $objeto->longitud }})">
                                                    <i class="bi bi-cursor"></i> Ver en mapa
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                                <p class="mt-2 mb-0">No hay objetos en esta capa</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- Leaflet CSS y JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Inicializar el mapa
        let map = L.map('mapa').setView([{{ $centroLat ?? 0 }}, {{ $centroLng ?? 0 }}], {{ $zoom ?? 13 }});

        // Agregar capa de tiles (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Agregar marcadores
        const objetos = @json($objetos);
        const markers = [];

        objetos.forEach(objeto => {
            if (objeto.latitud && objeto.longitud) {
                const marker = L.marker([objeto.latitud, objeto.longitud])
                    .addTo(map)
                    .bindPopup(`
                    <div class="text-center">
                        <h6 class="mb-2 fw-bold">${objeto.nombre}</h6>
                        ${objeto.direccion ? `<p class="mb-1 small text-muted"><i class="bi bi-geo-alt"></i> ${objeto.direccion}</p>` : ''}
                        ${objeto.telefono ? `<p class="mb-1 small"><i class="bi bi-telephone"></i> ${objeto.telefono}</p>` : ''}
                        ${objeto.email ? `<p class="mb-1 small"><i class="bi bi-envelope"></i> ${objeto.email}</p>` : ''}
                        ${objeto.url ? `<p class="mb-0 small"><a href="${objeto.url}" target="_blank" class="btn btn-sm btn-primary mt-2"><i class="bi bi-link-45deg"></i> Sitio web</a></p>` : ''}
                    </div>
                `);
                markers.push(marker);
            }
        });

        // Ajustar vista para mostrar todos los marcadores
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }

        // Controles del mapa
        document.getElementById('btn-zoom-in').addEventListener('click', () => {
            map.zoomIn();
        });

        document.getElementById('btn-zoom-out').addEventListener('click', () => {
            map.zoomOut();
        });

        document.getElementById('btn-reset').addEventListener('click', () => {
            if (markers.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            } else {
                map.setView([{{ $centroLat ?? 0 }}, {{ $centroLng ?? 0 }}], {{ $zoom ?? 13 }});
            }
        });

        // Función para centrar el mapa en un objeto específico
        function centrarMapa(lat, lng) {
            map.setView([lat, lng], 16);

            // Encontrar y abrir el popup del marcador
            markers.forEach(marker => {
                const markerLatLng = marker.getLatLng();
                if (markerLatLng.lat === lat && markerLatLng.lng === lng) {
                    marker.openPopup();
                }
            });
        }
    </script>
@endpush
