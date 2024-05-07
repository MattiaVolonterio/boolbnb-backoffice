@extends('layouts.app')
@section('title', 'Dashbord')

@section('css')

    @vite('resources/scss/dashboard.scss')

@endsection

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('Benvenuto ' . Auth::user()->name) }}</div>

                    <div class="card-body card-container">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row ">
                            <div class="col-md-6 col-lg-4 my-1 my-md-2">
                                <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary w-100">
                                    Inserisci un nuovo appartamento
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-4 my-1 my-md-2">
                                <a href="{{ route('admin.apartments.index') }}"
                                    class="btn btn-primary w-100 {{ Auth::user()->apartments->isEmpty() ? 'd-none' : 'd-block' }}">
                                    Gestisci i tuoi appartamenti
                                </a>
                            </div>
                        </div>

                        <div class="row bottom-page pt-3 mt-3">

                            {{-- accordio con i messaggi ricevuti dall'utente --}}
                            <div class="col-md-6 pb-3 pb-md-0">

                                <div class="card h-100">
                                    <div class="card-header">
                                        <h2 class="h3 text-center mb-3">Messaggi ricevuti per i tuoi appartamenti</h2>
                                    </div>
                                    <div class="card-body messages-body">
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                                        Appartamento interessato - indirizzo email mittente
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Testo del messaggio.</div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                                        aria-expanded="false" aria-controls="flush-collapseTwo">
                                                        Appartamento interessato - indirizzo email mittente
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Testo del messaggio..</div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                                        aria-expanded="false" aria-controls="flush-collapseThree">
                                                        Appartamento interessato - indirizzo email mittente
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Testo del messaggio.</div>
                                                </div>
                                            </div>
                                        </div>
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
        </div>
    </div>
@endsection
