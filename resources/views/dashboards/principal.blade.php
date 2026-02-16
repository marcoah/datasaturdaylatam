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
                        <h5 class="card-title">Alertas Varias</h5>

                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Primary Heading</h4>
                            <p>Et suscipit deserunt earum itaque dignissimos recusandae dolorem qui. Molestiae rerum
                                perferendis laborum. Occaecati illo at laboriosam rem molestiae sint.</p>
                            <hr>
                            <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Secondary Heading</h4>
                            <p>Et suscipit deserunt earum itaque dignissimos recusandae dolorem qui. Molestiae rerum
                                perferendis laborum. Occaecati illo at laboriosam rem molestiae sint.</p>
                            <hr>
                            <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Success Heading</h4>
                            <p>Et suscipit deserunt earum itaque dignissimos recusandae dolorem qui. Molestiae rerum
                                perferendis laborum. Occaecati illo at laboriosam rem molestiae sint.</p>
                            <hr>
                            <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Danger Heading</h4>
                            <p>Et suscipit deserunt earum itaque dignissimos recusandae dolorem qui. Molestiae rerum
                                perferendis laborum. Occaecati illo at laboriosam rem molestiae sint.</p>
                            <hr>
                            <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="alert alert-warning  alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Warning Heading</h4>
                            <p>Et suscipit deserunt earum itaque dignissimos recusandae dolorem qui. Molestiae rerum
                                perferendis laborum. Occaecati illo at laboriosam rem molestiae sint.</p>
                            <hr>
                            <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="alert alert-info  alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Info Heading</h4>
                            <p>Et suscipit deserunt earum itaque dignissimos recusandae dolorem qui. Molestiae rerum
                                perferendis laborum. Occaecati illo at laboriosam rem molestiae sint.</p>
                            <hr>
                            <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="alert alert-light border-light alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Lignt Heading</h4>
                            <p>Et suscipit deserunt earum itaque dignissimos recusandae dolorem qui. Molestiae rerum
                                perferendis laborum. Occaecati illo at laboriosam rem molestiae sint.</p>
                            <hr>
                            <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="alert alert-dark  alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Dark Heading</h4>
                            <p>Et suscipit deserunt earum itaque dignissimos recusandae dolorem qui. Molestiae rerum
                                perferendis laborum. Occaecati illo at laboriosam rem molestiae sint.</p>
                            <hr>
                            <p class="mb-0">Temporibus quis et qui aspernatur laboriosam sit eveniet qui sunt.</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                    </div>
                </div>
            </div> <!-- End Center side columns -->

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
        </div>

    </section>
@endsection

@push('scripts')
@endpush
