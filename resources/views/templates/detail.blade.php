@extends('layouts.escritorio')

@section('styles')
@endsection

@section('content')

    <div class="pagetitle">
        <h1>{{ __('Historial de Correos Enviados') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('email-history.index') }}">Historial de Correos Enviados</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">Historial de Correos Enviados</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="mb-4">
                <a href="{{ route('email-history.index') }}" class="btn btn-primary btn-sm">
                    ← Volver al historial
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informacion correo</h5>
                        <!-- Default Table -->
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Detalle del Correo</td>
                                    <td>
                                        @if ($emailHistory->status === 'sent')
                                            <span class="badge rounded-pill bg-success">Enviado</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">Fallido</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fecha de envío</td>
                                    <td> {{ $emailHistory->sent_at->format('d/m/Y H:i:s') }}
                                        <span
                                            style="font-size: 0.85rem;">({{ $emailHistory->sent_at->diffForHumans() }})</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tipo de correo</td>
                                    <td>{{ $emailHistory->mailable_class }}</td>
                                </tr>
                                <tr>
                                    <td>Asunto</td>
                                    <td>{{ $emailHistory->subject }}</td>
                                </tr>
                                <tr>
                                    <td>De:</td>
                                    <td>
                                        @if ($emailHistory->from_name)
                                            {{ $emailHistory->from_name }} &lt;{{ $emailHistory->from_email }}&gt;
                                        @else
                                            {{ $emailHistory->from_email }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Para</td>
                                    <td>
                                        @if (is_array($emailHistory->to))
                                            <ul class="list-disc list-inside">
                                                @foreach ($emailHistory->to as $recipient)
                                                    <li>{{ $recipient }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    @if ($emailHistory->cc)
                                        <td>CC</td>
                                        <td>
                                            <ul class="list-disc list-inside">
                                                @foreach ($emailHistory->cc as $cc)
                                                    <li>{{ $cc }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    @endif
                                    <!-- BCC -->
                                    @if ($emailHistory->bcc)
                                        <td>BCC</td>
                                        <td>
                                            <ul class="list-disc list-inside">
                                                @foreach ($emailHistory->bcc as $bcc)
                                                    <li>{{ $bcc }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    @endif
                                    <!-- Adjuntos -->
                                    @if ($emailHistory->attachments)
                                        <td>Adjuntos:</td>
                                        <td>
                                            <ul class="space-y-1">
                                                @foreach ($emailHistory->attachments as $attachment)
                                                    <li class="flex items-center gap-2">
                                                        <span>{{ $attachment['name'] ?? 'Sin nombre' }}</span>
                                                        <span
                                                            class="text-xs text-gray-500">({{ $attachment['type'] ?? 'unknown' }})</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    @endif
                                    <!-- Error (si falló) -->
                                    @if ($emailHistory->status === 'failed' && $emailHistory->error_message)
                                        <td>Error</td>
                                        <td>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ $emailHistory->error_message }}
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Contenido del Correo</h5>

                        <div x-data="{ tab: 'html' }">

                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-3">
                                <li class="nav-item">
                                    <button type="button" @click="tab = 'html'"
                                        :class="tab === 'html' ? 'nav-link active' : 'nav-link'">
                                        Vista HTML
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" @click="tab = 'text'"
                                        :class="tab === 'text' ? 'nav-link active' : 'nav-link'">
                                        Vista Texto
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" @click="tab = 'source'"
                                        :class="tab === 'source' ? 'nav-link active' : 'nav-link'">
                                        Código Fuente
                                    </button>
                                </li>
                            </ul>

                            <!-- Vista HTML -->
                            <div x-show="tab === 'html'" class="border rounded p-3 bg-white" style="min-height: 36rem;">
                                @if ($emailHistory->body_html)
                                    <iframe srcdoc="{!! htmlspecialchars($emailHistory->body_html) !!}" class="w-100 border-0" style="height: 36rem;"
                                        sandbox="allow-same-origin">
                                    </iframe>
                                @else
                                    <p class="text-muted mb-0">No hay código fuente disponible</p>
                                @endif
                            </div>

                            <!-- Vista Texto Plano -->
                            <div x-show="tab === 'text'" class="border rounded p-3 bg-light" style="min-height: 36rem;">
                                @if ($emailHistory->body_text)
                                    <pre class="font-monospace small mb-0" style="white-space: pre-wrap;">
{{ $emailHistory->body_text }}
                        </pre>
                                @else
                                    <p class="text-muted mb-0">No hay código fuente disponible</p>
                                @endif
                            </div>

                            <!-- Código Fuente -->
                            <div x-show="tab === 'source'" class="border rounded p-3 bg-white" style="min-height: 36rem;">
                                @if ($emailHistory->body_html)
                                    <pre class="text-success font-monospace small mb-0">
{{ $emailHistory->body_html }}
                        </pre>
                                @else
                                    <p class="text-muted mb-0">No hay código fuente disponible</p>
                                @endif
                            </div>

                        </div>

                        <!-- Acciones -->
                        <div class="text-center mt-4">
                            <form method="POST" action="{{ route('email-history.destroy', $emailHistory) }}"
                                onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Eliminar registro
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
