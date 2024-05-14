@extends('layouts.side-bar-layout')
@section('title', 'Dashbord')

@section('css')

    @vite('resources/scss/dashboard.scss')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection

@section('content')
    <div class="card border-bottom-0">

        <div class="card-header welcome-header rounded-0">
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
            <div class="card-body card-container pt-0">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif


                <div class="row bottom-page pt-3">

                    {{-- accordion con i messaggi ricevuti dall'utente --}}
                    <div class="col-md-6 pb-3 pb-md-0">

                        {{-- @dd($messages) --}}
                        <div class="card h-100">
                            <div class="card-header">
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
                    <div class="col-md-6">
                        {{-- Appartamenti sponsorizzati --}}
                        <div class="col-12 h-50">
                            <div class="card h-100">
                                <div class="card-header">
                                    Le tue sponsorizzazioni
                                </div>
                                <div class="card-body">
                                    Carosello immagini
                                </div>
                            </div>
                        </div>

                        {{-- Statistiche --}}
                        <div class="col-12 h-50 pt-3">
                            <div class="card h-100">
                                <div class="card-header">
                                    Le tue statistiche
                                </div>
                                <div class="card-body">
                                    Stats
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
