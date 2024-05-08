@extends('layouts.app')

@section('content')
    {{-- Container session message --}}
    @if (session('message-text'))
        <div class="alert {{ session('message-status') }} alert-dismissible fade show container mt-5" role="alert">
            {{ session('message-text') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="container py-3">

        {{-- BUTTONS --}}
        <div class="d-flex justify-content-between">
            <div>
                {{-- BACK TO APARTMENTS INDEX BUTTON --}}
                <button type="button" class="btn btn-primary me-3">
                    <i class="fa-solid fa-arrow-left me-1"></i>
                    <a href="{{ route('admin.apartments.index') }}" class="text-decoration-none text-white">
                        Torna alla lista
                    </a>
                </button>

                {{-- EDIT BUTTON --}}
                <button type="button" class="btn btn-warning">
                    <i class="fa-solid fa-pen-to-square "></i>

                    <a href="{{ route('admin.apartments.edit', $apartment->id) }}" class="text-decoration-none text-dark">
                        Modifica
                    </a>
                </button>
            </div>

            <div>
                {{-- MESSAGES INDEX BUTTON --}}
                <button type="button" class="btn btn-success">
                    <a href="{{ route('admin.messages.index', $apartment) }}" class="text-decoration-none text-white pe-2">
                        Vai ai messaggi
                    </a>

                    <i class="fa-solid fa-envelope"></i>
                </button>
            </div>
        </div>

        <h1 class="mt-5">{{ $apartment->name }}</h1>

        {{-- COVER-DATA-SERVICES --}}
        <div class="row mt-4">
            {{-- IMMAGINE COVER --}}
            <div class="col-md-6 col-12">

                {{-- img cover se nn ce img placeholder dal sito picsum --}}

                {{-- <img src="{{ $apartment->cover_img ? asset( $apartment->cover_img) : 'https://picsum.photos/200/300' }}"
                     class="card-img-top card-image-character mb-2" alt="{{ $apartment->name }}"> --}}

                <div class="card h-100">
                    <div class="card-header">
                        Immagine Principale
                    </div>

                    <img src="{{ $apartment->cover_img ? asset($apartment->cover_img) : 'https://picsum.photos/200/300' }}"
                        class="card-img-bottom" alt="{{ $apartment->name }}" style="min-height: 400px; max-height: 400px">
                </div>

            </div>

            {{-- DATI --}}
            <div class="col-md-3 col-6">

                <div class="card">
                    <div class="card-header">
                        Dati
                    </div>
                    <div class="card-body" style="min-height: 400px; max-height: 400px">
                        <ul class=" list-unstyled">
                            <li>
                                <div><strong>Nome: </strong>{{ $apartment->name }}</div>
                            </li>
                            <li>
                                <div><strong>Stanze: </strong>{{ $apartment->n_room }}</div>
                            </li>
                            <li>
                                <div><strong>Bagni: </strong>{{ $apartment->n_bathroom }}</div>
                            </li>
                            <li>
                                <div><strong>Posti Letto: </strong>{{ $apartment->n_bed }}</div>
                            </li>
                            <li>
                                <div><strong>Superficie: </strong>{{ $apartment->square_meters }}</div>
                            </li>
                            <li>
                                <div><strong>Piano: </strong>{{ $apartment->floor }}</div>
                            </li>
                            <li>
                                <div><strong>Indirizzo: </strong>{{ $apartment->address }}</div>
                            </li>
                            <li>
                                <div><strong>Lat: </strong>{{ $apartment->lat }}</div>
                            </li>
                            <li>
                                <div><strong>Lon: </strong>{{ $apartment->lon }}</div>
                            </li>
                            <li>
                                <div><strong>visibile: </strong>{{ $apartment->visible }}</div>
                            </li>
                        </ul>
                    </div>

                </div>


            </div>

            {{-- SERVIZI --}}
            <div class="col-md-3 col-6">

                <div class="card overflow-auto">
                    <div class="card-header position-relative">
                        Servizi
                    </div>

                    <div class="card-body overflow-auto" style="min-height: 400px; max-height: 400px">
                        <ul class=" list-unstyled">
                            <li class="">
                                @foreach ($services as $service)
                                    @if ($apartment->services->contains($service->id))
                                        <div class="form-check d-flex align-items-center p-0 ">
                                            <div class="me-2"><img src="{{ asset($service->icon) }}" alt=""
                                                    style="width: 30px;"></div>
                                            <label class="form-check-label" for="service_{{ $service->id }}">
                                                {{ $service->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>



        @if (!empty($apartment_images->items))
            <h1 class="mt-5">Le tue foto</h1>

            <div class="row mb-5">

                {{-- COLONNA CAROSELLO --}}
                <div class="col-md-6 col-12">
                    {{-- <h2 class="mb-3">Immagini dell'appartamento</h2> --}}

                    <div id="carouselExample" class="card carousel slide">

                        {{-- Carosello Immagini --}}
                        <div class="carousel-inner ms_carousel-inner">
                            @foreach ($apartment_images as $index => $apartment_image)
                                <div class="carousel-item ms_carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $apartment_image->url) }}"
                                        class="slide d-block w-100 h-100 object-fit-cover rounded-3" alt="Immagine mancante"
                                        style="max-height: 400px">
                                </div>
                            @endforeach
                        </div>

                        {{-- Sezione bottoni --}}
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"
                                style="background-color: #333;"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"
                                style="background-color: #333;"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>


                {{-- COLONNA IMMAGINI --}}
                <div class="col-md-6 col-12">
                    {{-- TEST-------------------------- --}}
                    <div class="row g-1" style="max-height: 400px;">

                        {{-- DA FIXARE --}}
                        @foreach ($apartment_images as $index => $apartment_image)
                            <div class="col-4">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $apartment_image->url) }}"
                                        class="thumb_img p-slide d-block w-100 h-100 object-fit-cover rounded-3"
                                        alt="Immagine mancante">
                                </div>
                            </div>
                        @endforeach

                    </div>
                    {{-- END TEST---------------------- --}}
                </div>

            </div>
        @endif
    </section>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    <script></script>
@endsection
