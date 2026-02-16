@extends('layouts.escritorio')

@section('styles')
@endsection

@section('content')
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Dashboard - DataSaturday LATAM</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-4">
                <!-- Card with header and footer -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informacion Basica</h5>
                        Ut in ea error laudantium quas omnis officia. Sit sed praesentium voluptas. Corrupti
                        inventore
                        consequatur nisi necessitatibus modi consequuntur soluta id. Enim autem est esse natus
                        assumenda.
                        Non sunt dignissimos officiis expedita. Consequatur sint repellendus voluptas.
                        Quidem sit est nulla ullam. Suscipit debitis ullam iusto dolorem animi dolorem numquam. Enim
                        fuga
                        ipsum dolor nulla quia ut.
                        Rerum dolor voluptatem et deleniti libero totam numquam nobis distinctio. Sit sint aut.
                        Consequatur
                        rerum in.
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">Button</a>
                    </div>
                </div><!-- End Card with header and footer -->
            </div><!-- End Left side columns -->

            <!-- Center side columns -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Alertas Importantes</h5>

                        @forelse($alertas as $alerta)
                            <div class="alert alert-{{ $alerta->tipo }} alert-dismissible fade show" role="alert"
                                data-alerta-id="{{ $alerta->id }}">
                                <h4 class="alert-heading">{{ $alerta->titulo }}</h4>
                                <p>{{ $alerta->mensaje }}</p>

                                @if ($alerta->mensaje_adicional)
                                    <hr>
                                    <p class="mb-0">{{ $alerta->mensaje_adicional }}</p>
                                @endif

                                <button type="button" class="btn-close btn-marcar-leida"
                                    data-alerta-id="{{ $alerta->id }}" aria-label="Close"></button>
                            </div>
                        @empty
                            <div class="alert alert-info" role="alert">
                                <p class="mb-0">No hay alertas en este momento.</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
            <!-- End Center side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- News & Updates Traffic -->
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                Noticias &amp; Actualizaciones
                            </h5>
                            <a href="{{ route('noticias.publico') }}" class="btn btn-sm btn-outline-primary">
                                Ver todas
                            </a>
                        </div>

                        <div class="news mt-3">
                            @forelse($noticias as $noticia)
                                <div class="post-item clearfix">
                                    @if ($noticia->imagen)
                                        <img src="{{ asset('storage/' . $noticia->imagen) }}"
                                            alt="{{ $noticia->titulo }}" />
                                    @else
                                        <img src="{{ asset('assets/img/default-news.jpg') }}"
                                            alt="{{ $noticia->titulo }}" />
                                    @endif
                                    <h4>
                                        <a href="{{ route('noticias.show', $noticia->id) }}">
                                            {{ $noticia->titulo }}
                                        </a>
                                    </h4>
                                    <p>
                                        {{ Str::limit($noticia->contenido, 80) }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ $noticia->fecha_publicacion->diffForHumans() }}
                                    </small>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-newspaper" style="font-size: 2rem;"></i>
                                    <p class="mt-2">No hay noticias disponibles en este momento</p>
                                </div>
                            @endforelse
                        </div>
                        <!-- End sidebar recent posts-->
                    </div>
                </div>
                <!-- End News & Updates -->
            </div>
            <!-- End Right side columns -->
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar el click en el botón de cerrar alerta
            document.querySelectorAll('.btn-marcar-leida').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    const alertaId = this.getAttribute('data-alerta-id');
                    const alertElement = this.closest('.alert');

                    // Marcar como leída en el servidor
                    fetch(`/alertas/${alertaId}/marcar-leida`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cerrar la alerta con animación de Bootstrap
                                const bsAlert = new bootstrap.Alert(alertElement);
                                bsAlert.close();
                            }
                        })
                        .catch(error => {
                            console.error('Error al marcar alerta como leída:', error);
                            // Aún así cerrar la alerta visualmente
                            const bsAlert = new bootstrap.Alert(alertElement);
                            bsAlert.close();
                        });
                });
            });
        });
    </script>
@endpush
