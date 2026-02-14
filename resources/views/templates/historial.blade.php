@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>{{ __('Historial de Correos Enviados') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active"><a href="#">Historial de Correos Enviados</a>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <form method="GET" action="{{ route('email-history.index') }}" class="space-y-4">
                            <!-- Búsqueda -->
                            <div class="row mb-3">
                                <label for="search" class="col-sm-2 col-form-label">Buscar</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="search" name="search"
                                        value="{{ request('search') }}" placeholder="Asunto, email, destinatario...">
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="row mb-3">
                                <label for="status" class="col-sm-2 col-form-label">Estado</label>
                                <div class="col-sm-4">
                                    <select name="status" class="form-select">
                                        <option value="">Todos</option>
                                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Enviados
                                        </option>
                                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>
                                            Fallidos</option>
                                    </select>
                                </div>

                                <!-- Tipo de Email -->
                                <label for="mailable_class" class="col-sm-2 col-form-label">Tipo</label>
                                <div class="col-sm-4">
                                    <select name="mailable_class" class="form-select">
                                        <option value="">Todos</option>
                                        @foreach ($mailableClasses as $class)
                                            <option value="{{ $class }}"
                                                {{ request('mailable_class') == $class ? 'selected' : '' }}>
                                                {{ class_basename($class) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Rango de fechas -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Fecha desde</label>
                                <div class="col-sm-4">
                                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                                        class="form-control">
                                </div>

                                <label class="col-sm-2 col-form-label">Fecha hasta</label>
                                <div class="col-sm-4">
                                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                                        class="form-control">
                                </div>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                                <a href="{{ route('email-history.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Mail list') }}</h5>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable" id="tabla" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Asunto</th>
                                        <th>Destinatario(s)</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($emails as $email)
                                        <tr>
                                            <td>
                                                {{ $email->sent_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                {{ Str::limit($email->subject, 50) }}
                                            </td>
                                            <td>
                                                @if (is_array($email->to))
                                                    {{ implode(', ', array_slice($email->to, 0, 2)) }}
                                                    @if (count($email->to) > 2)
                                                        <span class="text-gray-500">+{{ count($email->to) - 2 }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                {{ $email->mailable_name }}
                                            </td>
                                            <td>
                                                @if ($email->status === 'sent')
                                                    <span class="badge rounded-pill bg-success">Enviado</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">Fallido</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{ route('email-history.show', $email) }}"
                                                        class="btn btn-primary btn-sm" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('email-history.destroy', $email) }}"
                                                        onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Eliminar"><i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                No se encontraron correos en el historial.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if ($emails->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $emails->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            @endsection
