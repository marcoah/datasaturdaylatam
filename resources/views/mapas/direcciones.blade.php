@extends('layouts.escritorio')

@section('styles')
    <style type="text/css">
        #map {
            height: 600px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <!-- Contenido Central -->
            <main role="main" class="col-lg-12 col-sm-12 col-md-12 ml-sm-auto px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 col-sm-12 border-bottom">
                    <h1>Obtener Coordenadas a partir de una dirección</h1>
                </div>
            </main><!-- Fin contenido central -->
        </div>
        <div class="row">
            <div class="col-md-9">
                <div id="app"></div>
                <div id="map"></div>
            </div>
            <div class="col-md-3">
                <div id="formulario">
                    <input type="text" id="search">
                    <input type="button" value="Buscar Dirección" onClick="getCoords()">
                </div>
                <div id="coordenadas">
                    <table class="table table-dark">
                        <thead>
                          <tr>
                            <th scope="col">Latitud</th>
                            <th scope="col">Longitud</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td id="latitud"></td>
                            <td id="longitud"></td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
    <script type="text/javascript">
        var geocoder;
        var map;

        function initMap() {
            var centro = {lat: 10.2442, lng: -67.6066};
            map = new google.maps.Map(document.getElementById('map'), {
                center: centro,
                scrollwheel: false,
                zoom: 12,
                zoomControl: true,
                rotateControl : false,
                mapTypeControl: true,
                streetViewControl: false,
            });
            document.getElementById("coordenadas").style.display = 'none'
        }

        function getCoords() {
            geocoder = new google.maps.Geocoder();
            address = document.getElementById('search').value;

            if(address!=''){
                geocoder.geocode({ 'address': address}, function(results, status) {
                    if (status == 'OK'){
                        //document.getElementById("coordenadas").innerHTML='Coordenadas:   '+results[0].geometry.location.lat()+', '+results[0].geometry.location.lng();
                        document.getElementById("coordenadas").style.display = 'block'

                        document.getElementById("latitud").innerHTML=results[0].geometry.location.lat();
                        document.getElementById("longitud").innerHTML=results[0].geometry.location.lng();

                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });
                    }
                });
            }
        }
    </script>
@endpush
