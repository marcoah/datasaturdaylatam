@extends('layouts.escritorio')

@section('content')
    <div class="pagetitle">
        <h1>Ponencias</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Ponencias</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <!-- Alerts -->
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Ponencias</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #f6f9ff; color: #4154f1; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-easel"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="mb-0 display-6">{{ $stats['total'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ponencias Aprobadas</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #e0f8e9; color: #2eca6a; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="mb-0 display-6 text-success">{{ $stats['aprobadas'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pendientes de Aprobar</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #fff3cd; color: #ffc107; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="mb-0 display-6 text-warning">{{ $stats['pendientes'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Ponencias -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Lista de Ponencias</h5>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalImportarExcel">
                                    <i class="bi bi-file-excel"></i> Importar Excel
                                </button>
                                <a href="{{ route('ponencias.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Crear Ponencia
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Ponente</th>
                                        <th>Título</th>
                                        <th>Fecha y Hora</th>
                                        <th>Nivel</th>
                                        <th>Archivo</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ponencias as $ponencia)
                                        <tr>
                                            <td>
                                                <i class="bi bi-person-fill text-primary me-2"></i>
                                                <strong>{{ $ponencia->user->name }}</strong><br>
                                                <small class="text-muted">{{ $ponencia->user->email }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $ponencia->titulo }}</strong><br>
                                                <small
                                                    class="text-muted">{{ Str::limit($ponencia->descripcion, 60) }}</small>
                                            </td>
                                            <td>
                                                <i class="bi bi-calendar-event text-info me-1"></i>
                                                {{ $ponencia->fecha_hora_ponencia }}
                                            </td>
                                            <td>
                                                @if ($ponencia->nivel === 'basico')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-star"></i> Básico
                                                    </span>
                                                @elseif($ponencia->nivel === 'intermedio')
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-star-fill"></i> Intermedio
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-stars"></i> Avanzado
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ponencia->archivo)
                                                    <a href="{{ asset('storage/' . $ponencia->archivo) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-file-earmark-pdf"></i> Ver
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin archivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ponencia->aprobada)
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle-fill"></i> Aprobada
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-clock"></i> Pendiente
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('ponencias.show', $ponencia->id) }}"
                                                        class="btn btn-info" title="Ver">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('ponencias.edit', $ponencia->id) }}"
                                                        class="btn btn-warning" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('ponencias.toggle', $ponencia->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-{{ $ponencia->aprobada ? 'secondary' : 'success' }}"
                                                            title="{{ $ponencia->aprobada ? 'Marcar pendiente' : 'Aprobar' }}">
                                                            <i
                                                                class="bi bi-{{ $ponencia->aprobada ? 'x-circle' : 'check-circle' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('ponencias.destroy', $ponencia->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('¿Estás seguro de eliminar esta ponencia?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Eliminar">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-2">No hay ponencias registradas</p>
                                                <a href="{{ route('ponencias.create') }}" class="btn btn-primary">
                                                    <i class="bi bi-plus-circle"></i> Crear Primera Ponencia
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if ($ponencias->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $ponencias->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Importar Excel -->
    <div class="modal fade" id="modalImportarExcel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ponencias.importar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Importar Ponencias desde Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">Formato del archivo Excel</h6>
                            <p class="mb-2">El archivo debe contener las siguientes columnas:</p>
                            <ul class="mb-0 small">
                                <li><strong>nombre</strong> - Nombre del ponente</li>
                                <li><strong>apellido</strong> - Apellido del ponente</li>
                                <li><strong>email</strong> - Email del ponente</li>
                                <li><strong>titulo</strong> - Título de la ponencia</li>
                                <li><strong>descripcion</strong> - Descripción de la ponencia</li>
                                <li><strong>fecha_ponencia</strong> - Fecha (formato: YYYY-MM-DD)</li>
                                <li><strong>horario_ponencia</strong> - Hora (formato: HH:MM)</li>
                                <li><strong>nivel</strong> - basico, intermedio o avanzado</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label for="archivo_excel" class="form-label">Archivo Excel</label>
                            <input type="file" class="form-control @error('archivo_excel') is-invalid @enderror"
                                id="archivo_excel" name="archivo_excel" accept=".xlsx,.xls,.csv" required>
                            @error('archivo_excel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload"></i> Importar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
