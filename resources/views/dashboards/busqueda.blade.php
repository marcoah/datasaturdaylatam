@extends('layouts.escritorio')

@section('styles')

@endsection

@section('content')
    <div id="app"></div>
    <div class="container">
        <div class="row">
            <!-- Contenido Central -->
            <main role="main" class="col-lg-12 col-sm-12 col-md-12 ml-sm-auto px-4">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 col-sm-12 border-bottom">
                    <h1>Resultado de la búsqueda: {{$search}} </h1>
                </div>

                <div class="col-sm-12">
                    @isset($message)
                    <div class="alert alert-warning" role="alert">
                        {{$message}}
                    </div>
                    @endisset
                </div>

                <div class="col-sm-12">
                    @isset($resultados)
                    <h3>Total Resultados: {{ $resultados->total() }}</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nombre Completo</td>
                                <td>Correo Principal</td>
                                <td>Celular</td>
                                <td>Otro</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resultados as $resultado)
                            <tr>
                                <td>{{$resultado->id}}</td>
                                <td>{{$resultado->cliente_nombre}}</td>
                                <td>{{$resultado->cliente_email1}}</td>
                                <td>{{$resultado->cliente_celular}}</td>
                                <td></td>
                                <td>
                                    <a class="btn btn-secondary btn-sm" href="{{ route('clientes.show',$resultado->id) }}" data-toggle="tooltip" data-placement="top" title="Mostrar"><i class="fas fa-eye"></i> Ver detalles</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $resultados->links() }}
                @endisset

            </main><!-- Fin contenido central -->
        </div>
    </div>
@endsection

@push('scripts')

@endpush
