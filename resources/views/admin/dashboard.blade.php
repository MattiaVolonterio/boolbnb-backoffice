@extends('layouts.side-bar-layout')
@section('title', 'Dashbord')

@section('css')

    @vite('resources/scss/dashboard.scss')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection

@section('content')
    {{-- <div class="card border-bottom-0"> --}}

    <div class="card-header welcome-header ps-4 rounded-0">
        {{ __('Benvenuto ' . Auth::user()->name) }}
    </div>

    <div class="main-content-container">

        {{-- Bottoni --}}
        <div class="button-container">
            <a href="{{ route('admin.apartments.create') }}" class="button-gradient">
                Inserisci un nuovo appartamento
            </a>

            <a href="{{ route('admin.apartments.index') }}"
                class="button-gradient {{ Auth::user()->apartments->isEmpty() ? 'd-none' : 'd-block' }}">
                Gestisci i tuoi appartamenti
            </a>
        </div>
        <div class="card-container pt-0">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif


            <div class="row bottom-page g-3 pt-3">
                {{-- accordion con i messaggi ricevuti dall'utente --}}
                <div class="col-lg-6 pb-lg-3 ">
                    <div class="card h-100 accordion-container">
                        <div class="card-header z-0">
                            <h2 class="h3 text-center mb-3">Messaggi ricevuti per i tuoi appartamenti</h2>
                        </div>
                        <div class="card-body messages-body">
                            @foreach ($messages as $message)
                                <div for class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-{{ $message['id'] }}"
                                                aria-expanded="false" aria-controls="flush-{{ $message['id'] }}">
                                                {{ $message['apartment']['name'] }} -
                                                {{ $message['customer_email'] }} -
                                                {{ $message['created_at'] }}
                                            </button>
                                        </h2>
                                        <div id="flush-{{ $message['id'] }}" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">{{ $message['content'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 pb-lg-3">
                    {{-- Appartamenti sponsorizzati --}}
                    <div class="col-12">
                        <div class="card slider-container">
                            <div class="card-header">
                                Le tue sponsorizzazioni
                            </div>
                            <div class="card-body d-flex gap-2 align-items-center justify-content-between">
                                @if (count($apartments_sponsor) != 0)
                                    <div class="slide-button-left" id="slide-left"><i
                                            class="fa-solid fa-arrow-left fa-xl"></i>
                                    </div>
                                    <div class="slider-spons-container" id="slider">
                                        @foreach ($apartments_sponsor as $apartment)
                                            <div class="slider-spons-img-container">
                                                <a href="{{ route('admin.apartments.show', $apartment->id) }}">
                                                    <img class="slider-spons-img" src="{{ $apartment->cover_img }}"
                                                        alt="{{ $apartment->name }}">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="slide-button-right" id="slide-right"><i
                                            class="fa-solid fa-arrow-right fa-xl"></i>
                                    </div>
                                @else
                                    Nessuna Sponsorizzazione attiva
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Statistiche --}}
                    <div class="col-12 pt-3 pb-3 pb-lg-0">
                        <div class="card statistics-container">
                            <div class="card-header">
                                Le tue statistiche
                            </div>
                            <div class="card-body">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
@endsection

@section('js')

    {{-- Chart  --}}
    <script>
        const data = @json($data);
        const labels = data.labels;
        const messages = data.messages;
        const views = data.views;
    </script>

    @vite('resources/js/mychart.js')

    {{-- Slider --}}
    <script>
        const slider = document.getElementById('slider');
        const slideRight = document.getElementById('slide-right');
        const slideLeft = document.getElementById('slide-left');


        slideRight.addEventListener('click', function() {
            slider.scrollLeft += 250;
        })
        slideLeft.addEventListener('click', function() {
            slider.scrollLeft -= 250;
        })
    </script>
@endsection
