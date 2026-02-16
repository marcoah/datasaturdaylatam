@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>Alertas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Alertas</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Alertas</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #f6f9ff; color: #4154f1; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-bell"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="mb-0 display-6">{{ $stats['total'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Alertas Activas</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #e0f8e9; color: #2eca6a; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="mb-0 display-6 text-success">{{ $stats['activas'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Alertas Globales</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #fff3cd; color: #ffc107; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-globe"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="mb-0 display-6 text-warning">{{ $stats['globales'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Personalizadas</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #e7f3ff; color: #0dcaf0; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="mb-0 display-6 text-info">{{ $stats['personalizadas'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Alertas -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Lista de Alertas</h5>
                            <a href="{{ route('alertas.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Crear Alerta
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Usuario</th>
                                        <th>Vigencia</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($alertas as $alerta)
                                        <tr>
                                            <td>
                                                <strong>{{ $alerta->titulo }}</strong><br>
                                                <small class="text-muted">{{ Str::limit($alerta->mensaje, 50) }}</small>
                                                @if ($alerta->usuariosQueHanLeido()->count() > 0)
                                                    <br>
                                                    <small class="badge bg-info mt-1">
                                                        <i class="bi bi-eye"></i>
                                                        {{ $alerta->usuariosQueHanLeido()->count() }} lecturas
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $alerta->tipo }}">
                                                    {{ ucfirst($alerta->tipo) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($alerta->user)
                                                    <i class="bi bi-person-fill text-primary me-1"></i>
                                                    {{ $alerta->user->fullname }}
                                                @else
                                                    <i class="bi bi-globe text-warning me-1"></i>
                                                    <span class="text-muted">Global</span>
                                                @endif
                                            </td>
                                            <td class="small">
                                                @if ($alerta->fecha_inicio || $alerta->fecha_fin)
                                                    @if ($alerta->fecha_inicio)
                                                        Desde: {{ $alerta->fecha_inicio->format('d/m/Y') }}<br>
                                                    @endif
                                                    @if ($alerta->fecha_fin)
                                                        Hasta: {{ $alerta->fecha_fin->format('d/m/Y') }}
                                                    @endif
                                                @else
                                                    <span class="text-muted">Permanente</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($alerta->activa)
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i> Activa
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-pause-circle"></i> Inactiva
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('alertas.show', $alerta->id) }}"
                                                    class="btn btn-primary btn-sm" title="Ver">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('alertas.edit', $alerta->id) }}"
                                                    class="btn btn-success btn-sm" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('alertas.toggle', $alerta->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-{{ $alerta->activa ? 'warning' : 'info' }} btn-sm"
                                                        title="{{ $alerta->activa ? 'Desactivar' : 'Activar' }}">
                                                        <i
                                                            class="bi bi-{{ $alerta->activa ? 'pause' : 'play' }}-circle"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('alertas.destroy', $alerta->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar esta alerta?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-2">No hay alertas registradas</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($alertas->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $alertas->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
