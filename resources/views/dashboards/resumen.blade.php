@extends('layouts.escritorio')

@section('styles')
<!-- Estilos Datatables -->
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="app"></div>

    <div class="card">
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Suscripciones activas
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="tabla-suscripciones" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Fecha inicio</th>
                                        <th scope="col">Fecha final</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Factura</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suscripciones as $suscripcion)
                                    <tr>
                                        <td>{{$suscripcion->id}}</td>
                                        <td>{{$suscripcion->producto->producto_nombre}}</td>
                                        <td>{{$suscripcion->suscripcion_fecha_inicio->format('d M Y') }}</td>
                                        <td>{{$suscripcion->suscripcion_fecha_final->format('d M Y')}}</td>

                                        <td>
                                            @switch($suscripcion->suscripcion_status)
                                                @case('Activo')
                                                    <span class="badge badge-success">{{ $suscripcion->suscripcion_status }}</span>
                                                    @break

                                                @case('Pendiente')
                                                    <span class="badge badge-warning">{{ $suscripcion->suscripcion_status }}</span>
                                                    @break

                                                @case('Vencido')
                                                    <span class="badge badge-danger">{{ $suscripcion->suscripcion_status }}</span>
                                                    @break

                                            @endswitch
                                        </td>
                                        <td>{{$suscripcion->documento_id}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Documentos emitidos
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="tabla-documentos" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Documento</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Moneda</th>
                                        <th scope="col">Monto</th>
                                        <th scope="col">Estado</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentos as $documento)
                                    <tr>
                                        <td>{{$documento->id}}</td>
                                        <td>{{$documento->documento_tipo}}-{{$documento->documento_numero}}</td>
                                        <td>{{$documento->documento_fecha_emision->format('d M Y') }}</td>
                                        <td>{{$documento->documento_moneda}}</td>
                                        <td>{{ number_format($documento->documento_total, 2, ',', '.') }}</td>
                                        <td>
                                            @switch($documento->documento_status)
                                                @case('PAGADO')
                                                    <span class="badge badge-success">{{ $documento->documento_status }}</span>
                                                    @break
                                                @case('PENDIENTE')
                                                    <span class="badge badge-warning">{{ $documento->documento_status }}</span>
                                                    @break
                                                @case('Por Verificar')
                                                    <span class="badge badge-info">{{ $documento->documento_status }}</span>
                                                    @break
                                                @case('VENCIDO')
                                                    <span class="badge badge-danger">{{ $documento->documento_status }}</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td style="width: 140px;">
                                            <a class="btn btn-primary btn-sm" href="{{ route('documentos.show',$documento->id) }}" data-toggle="tooltip" data-placement="top" title="Mostrar"><i class="fas fa-eye"></i> Ver detalles</a>
                                            @switch($documento->documento_status)
                                            @case('PAGADO')
                                                <a class="btn btn-primary btn-sm" href="{{ route('pagos.show',$documento->id) }}" data-toggle="tooltip" data-placement="top" title="Mostrar">Ver Pago</a>
                                                @break
                                            @case('Por verificar')
                                                @break
                                            @case('PENDIENTE')
                                                <a class="btn btn-secondary btn-sm" href="{{ route('pagos.create',$documento->id) }}" data-toggle="tooltip" data-placement="top" title="registrar pago">Registrar Pago</a>
                                                @break
                                            @default
                                        @endswitch
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Citas pendientes
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        No hay citas programadas en este momento.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('js/jszip.min.js')}}"></script>
<script src="{{ asset('js/pdfmake.min.js')}}"></script>
<script src="{{ asset('js/vfs_fonts.js')}}"></script>
<script src="{{ asset('js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('js/buttons.print.min.js')}}"></script>
<script src="{{ asset('js/buttons.colVis.min.js')}}"></script>

<!-- Page specific script -->
<script>
    $(function () {
        $('#tabla-suscripciones').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json'
            },
            paging : true,
            lengthChange : true,
            searching : true,
            ordering : true,
            info : true,
            autoWidth : true,
            responsive : true,
        });

        $('#tabla-documentos').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json'
            },
            paging : true,
            lengthChange : true,
            searching : true,
            ordering : true,
            info : true,
            autoWidth : true,
            responsive : true,
        });
    });
</script>
@endpush
