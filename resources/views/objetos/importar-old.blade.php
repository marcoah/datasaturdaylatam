@extends('layouts.escritorio')

@section('styles')
@endsection

@section('content')

    <form action="{{ route('objetos.importar', 4) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="geojson" class="form-label">Archivo GeoJSON</label>
            <input type="file" name="geojson" id="geojson" accept=".geojson,.json" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="capa_id" class="form-label">Seleccionar capa destino</label>
            <select name="capa_id" id="capa_id" class="form-select" required>
                <option value="" disabled selected>-- Seleccione una capa --</option>
                @foreach ($capas as $capa)
                    <option value="{{ $capa->id }}">{{ $capa->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Subir y guardar</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection

@push('scripts')
@endpush
