@extends('layouts.escritorio')

@section('content')

    <div class="pagetitle">
        <h1>Códigos de Descuento</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Códigos de Descuento</li>
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

                        @if (session('codigos'))
                            <hr>
                            <p class="mb-2 fw-bold">Códigos generados:</p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach (session('codigos') as $codigo)
                                    <span class="badge bg-dark fs-6">{{ $codigo }}</span>
                                @endforeach
                            </div>
                        @endif
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
                        <h5 class="card-title">Total de Códigos</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #f6f9ff; color: #4154f1; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-ticket-perforated"></i>
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
                        <h5 class="card-title">Códigos Disponibles</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #e0f8e9; color: #2eca6a; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="mb-0 display-6 text-success">{{ $stats['disponibles'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Códigos Usados</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                style="background-color: #ffe8e0; color: #ff771d; font-size: 32px; width: 64px; height: 64px;">
                                <i class="bi bi-x-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="mb-0 display-6 text-warning">{{ $stats['usados'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Lista de Códigos</h5>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalGenerarCodigos">
                                    <i class="bi bi-plus-circle"></i> Generar Códigos
                                </button>
                                <a href="{{ route('descuentos.create') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-ticket"></i> Crear Código Individual
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Tipo</th>
                                        <th>Valor</th>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>Vigencia</th>
                                        <th>Usado en</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($descuentos as $descuento)
                                        <tr class="{{ $descuento->usado ? 'table-secondary' : '' }}">
                                            <td>
                                                <span class="badge bg-dark fs-6 font-monospace">
                                                    {{ $descuento->codigo }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($descuento->tipo === 'porcentaje')
                                                    <span class="badge bg-info">
                                                        <i class="bi bi-percent"></i> Porcentaje
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-currency-dollar"></i> Monto Fijo
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">
                                                @if ($descuento->tipo === 'porcentaje')
                                                    {{ $descuento->porcentaje }}%
                                                @else
                                                    ${{ number_format($descuento->monto_fijo, 2) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($descuento->user)
                                                    <i class="bi bi-person-fill text-primary"></i>
                                                    {{ $descuento->user->name }}
                                                @else
                                                    <span class="text-muted">Sin asignar</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($descuento->usado)
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-check-circle-fill"></i> Usado
                                                    </span>
                                                @elseif(!$descuento->activo)
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-pause-circle"></i> Inactivo
                                                    </span>
                                                @elseif($descuento->fecha_expiracion && $descuento->fecha_expiracion->lt(now()))
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-clock-history"></i> Expirado
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i> Disponible
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="small">
                                                @if ($descuento->fecha_inicio || $descuento->fecha_expiracion)
                                                    @if ($descuento->fecha_inicio)
                                                        Desde: {{ $descuento->fecha_inicio->format('d/m/Y') }}<br>
                                                    @endif
                                                    @if ($descuento->fecha_expiracion)
                                                        Hasta: {{ $descuento->fecha_expiracion->format('d/m/Y') }}
                                                    @endif
                                                @else
                                                    <span class="text-muted">Sin límite</span>
                                                @endif
                                            </td>
                                            <td class="small">
                                                @if ($descuento->usado_en)
                                                    {{ $descuento->usado_en->format('d/m/Y H:i') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>

                                                @if (!$descuento->usado)
                                                    <form action="{{ route('descuentos.toggle', $descuento->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-{{ $descuento->activo ? 'warning' : 'success' }}"
                                                            title="{{ $descuento->activo ? 'Desactivar' : 'Activar' }}">
                                                            <i
                                                                class="bi bi-{{ $descuento->activo ? 'pause' : 'play' }}-circle"></i>
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('descuentos.destroy', $descuento->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('¿Estás seguro de eliminar este código?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Eliminar">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary" disabled title="Código ya usado">
                                                        <i class="bi bi-lock"></i>
                                                    </button>
                                                @endif

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-2">No hay códigos de descuento registrados</p>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalGenerarCodigos">
                                                    <i class="bi bi-plus-circle"></i> Generar Códigos
                                                </button>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        @if ($descuentos->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $descuentos->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Generar Códigos -->
    <div class="modal fade" id="modalGenerarCodigos" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('descuentos.generar') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Generar Códigos de Descuento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad de códigos</label>
                            <input type="number" class="form-control @error('cantidad') is-invalid @enderror"
                                id="cantidad" name="cantidad" min="1" max="100" value="10" required>
                            @error('cantidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Máximo 100 códigos por vez</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de descuento</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipo_porcentaje"
                                    value="porcentaje" checked onchange="toggleTipoDescuento()">
                                <label class="form-check-label" for="tipo_porcentaje">
                                    Porcentaje
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipo_monto"
                                    value="monto_fijo" onchange="toggleTipoDescuento()">
                                <label class="form-check-label" for="tipo_monto">
                                    Monto Fijo
                                </label>
                            </div>
                        </div>

                        <div class="mb-3" id="campo_porcentaje">
                            <label for="porcentaje" class="form-label">Porcentaje de descuento</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('porcentaje') is-invalid @enderror"
                                    id="porcentaje" name="porcentaje" min="0" max="100" step="0.01"
                                    value="10">
                                <span class="input-group-text">%</span>
                                @error('porcentaje')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3" id="campo_monto_fijo" style="display: none;">
                            <label for="monto_fijo" class="form-label">Monto fijo de descuento</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control @error('monto_fijo') is-invalid @enderror"
                                    id="monto_fijo" name="monto_fijo" min="0" step="0.01">
                                @error('monto_fijo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label">Fecha de inicio (opcional)</label>
                                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                                    id="fecha_inicio" name="fecha_inicio">
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_expiracion" class="form-label">Fecha de expiración (opcional)</label>
                                <input type="date" class="form-control @error('fecha_expiracion') is-invalid @enderror"
                                    id="fecha_expiracion" name="fecha_expiracion">
                                @error('fecha_expiracion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-lightning-fill"></i> Generar Códigos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function toggleTipoDescuento() {
            const tipoPorcentaje = document.getElementById('tipo_porcentaje').checked;
            const campoPorcentaje = document.getElementById('campo_porcentaje');
            const campoMontoFijo = document.getElementById('campo_monto_fijo');

            if (tipoPorcentaje) {
                campoPorcentaje.style.display = 'block';
                campoMontoFijo.style.display = 'none';
                document.getElementById('porcentaje').required = true;
                document.getElementById('monto_fijo').required = false;
            } else {
                campoPorcentaje.style.display = 'none';
                campoMontoFijo.style.display = 'block';
                document.getElementById('porcentaje').required = false;
                document.getElementById('monto_fijo').required = true;
            }
        }
    </script>
@endpush
