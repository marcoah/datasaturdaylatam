@extends('layouts.escritorio')

@section('styles')
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>{{ __('Templates list') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('templates.index') }}">{{ __('Templates list') }}</a>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="alerts">
        <!-- Alertas -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                @if (session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Posts list') }}</h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable" id="tabla" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">{{ __('Template Title') }}</th>
                                        <th scope="col">{{ __('Template Use') }}</th>
                                        <th scope="col">{{ __('Tag') }}</th>
                                        <th scope="col" data-sortable="false">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($templates as $template)
                                        <tr>
                                            <td>{{ $template->id }}</td>
                                            <td>{{ $template->title }}</td>
                                            <td>{{ $template->use }}</td>
                                            <td>{{ $template->slug }}</td>
                                            <td style="width: 180px;">
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('templates.show', $template->id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Show">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @can('templates-update')
                                                    <a class="btn btn-success btn-sm"
                                                        href="{{ route('templates.edit', $template->id) }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('templates-delete')
                                                    <a class="btn btn-danger btn-sm" href="" data-bs-toggle="modal"
                                                        data-bs-target="#modalEliminar{{ $template->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>

                                        <!-- modalEliminar se muestra al hacer click en boton de borrar ------>
                                        <div class="modal fade" id="modalEliminar{{ $template->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex justify-content-center">
                                                        <h4>{{ __('Delete template') }}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-center">{{ __('Are you sure?') }}</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">
                                                            <i class="fa-solid fa-xmark"></i> {{ __('Cancel') }}
                                                        </button>
                                                        <form action="{{ route('templates.destroy', $template->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm" type="submit">
                                                                <i class="fas fa-trash-alt"></i>
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--fin modal-->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
@endpush
