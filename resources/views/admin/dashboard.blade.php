@extends('layouts.app-only-main')
@section('title', 'Dashbord')

@section('css')

    @vite('resources/scss/dashboard.scss')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection

@section('content')
    <div class="main-container">
        <div class="side-bar">
            {{-- side title --}}
            <div class="text-center pt-2 title-container fw-semibold">
                <div class="logo-container">
                    <img class="logo-img" src="{{ asset('img/logos/boolbnb-logo.png') }}" alt="logo">
                </div>
            </div>


            <div class="d-flex flex-column link-container">
                {{-- Navigation Link --}}
                <div class="text-center">
                    <ul class="navbar-nav mt-5">
                        <li class="nav-item ">
                            <a @class([
                                'nav-link',
                                'active' => Route::currentRouteName() == 'admin.apartments.index',
                            ]) aria-current="page"
                                href="{{ route('admin.apartments.index') }}"> <i
                                    class="fa-solid fa-house me-2"></i>Appartamenti</a>
                        </li>
                </div>

                {{-- gestione account --}}
                <div class="text-center mt-auto">
                    <li class="nav-item dropdown-center" data-bs-theme="dark">
                        <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown" href="#" id="navbarDropdown" role="button" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}"> Dashboard</a>
                            <a class="dropdown-item text-danger" href="{{ url('profile') }}"> Elimina Profilo</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" id="logout-link">
                                Logout
                            </a>

                            <form action="{{ route('logout') }}" class="d-none" id="logout-form" method="POST">
                                @csrf
                            </form>
                        </div>
                    </li>
                </div>

            </div>

        </div>
        <div class="main-content">

            <div class="col">
                <div class="card border-bottom-0">


                    <div class="card-header welcome-header rounded-0">
                        {{ __('Benvenuto ' . Auth::user()->name) }}
                    </div>

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
