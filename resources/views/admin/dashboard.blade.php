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
                <div class="logo-container pt-3 pt-lg-0">
                    <a href="{{ route('admin.dashboard') }}">
                        <img class="logo-img" src="{{ asset('img/logos/boolbnb-logo-2.png') }}" alt="logo">
                    </a>
                </div>
            </div>


            <div class="d-flex flex-column link-container">
                {{-- Navigation Link --}}
                <div class="d-flex flex-column align-items-center">
                    <ul class="navbar-nav mt-5">
                        <li class="nav-item ">
                            <a @class([
                                'nav-link',
                                'active' => Route::currentRouteName() == 'admin.dashboard',
                            ]) aria-current="page" href="{{ route('admin.dashboard') }}">
                                <div class="d-flex d-lg-block justify-content-center">
                                    <i class="fa-solid fa-house me-lg-2 mt-lg-4 fs-5"></i>
                                    <span class="d-none d-lg-inline-block">Home</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a @class([
                                'nav-link',
                                'active' => Route::currentRouteName() == 'admin.apartments.index',
                            ]) aria-current="page"
                                href="{{ route('admin.apartments.index') }}">
                                <div class="d-flex d-lg-block justify-content-center">
                                    <i class="fa-solid fa-building me-lg-2 mt-lg-1 fs-5"></i>
                                    <span class="d-none d-lg-inline-block">Appartamenti</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a @class([
                                'nav-link',
                                'active' => Route::currentRouteName() == 'admin.sponsorships.index',
                            ]) aria-current="page"
                                href="{{ route('admin.sponsorships.index') }}">
                                <div class="d-flex d-lg-block justify-content-center">
                                    <i class="fa-solid fa-money-check-dollar me-lg-2 mt-lg-1 fs-5"></i>
                                    <span class="d-none d-lg-inline-block">Sponsorship</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a @class([
                                'nav-link',
                                // 'active' => Route::currentRouteName() == 'admin.messages.index',
                            ]) aria-current="page" href="#">
                                <div class="d-flex d-lg-block justify-content-center">
                                    <i class="fa-solid fa-message me-lg-2 mt-lg-1 fs-5"></i>
                                    <span class="d-none d-lg-inline-block">Messaggi</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- gestione account --}}
                <div class="text-center mt-auto">
                    <li class="nav-item nav-link dropdown-center" data-bs-theme="dark">
                        <a aria-expanded="false" aria-haspopup="true" class="nav-link" data-bs-toggle="dropdown"
                            href="#" id="navbarDropdown" role="button" v-pre>
                            <i class="fa-solid fa-user-gear me-lg-2 fs-5"></i>
                            <span class="d-none d-lg-inline-block">{{ Auth::user()->name }}</span>
                        </a>

                        <div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-right">
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

                    {{-- navbar small --}}
                    <div class="top-nav-small">
                        <div class="logo-container-small">
                            <a href="{{ route('admin.dashboard') }}">
                                <img class="logo-img-small" src="{{ asset('img/logos/boolbnb-logo-2.png') }}"
                                    alt="logo">
                            </a>
                        </div>

                        {{-- offcanvas --}}
                        <button class="offcanvas-button" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i
                                class="fa-solid fa-bars fa-xl"></i></button>
                    </div>


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
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                                                            aria-controls="flush-collapseThree">
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
    </div>


    {{-- Offcanvas show --}}
    <div class="offcanvas offcanvas-end show-fade" tabindex="-1" id="offcanvasRight"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header d-flex justify-content-between align-items-center">
            <h5 class="offcanvas-title" id="offcanvas-title" id="offcanvasRightLabel">Menù</h5>
            <button type="button" id="button-close-offcanvas" data-bs-dismiss="offcanvas" aria-label="Close"><i
                    class="fa-solid fa-xmark fa-xl"></i></button>
        </div>
        <div class="offcanvas-body" id="offcanvas-body">
            <div class="d-flex flex-column">
                <ul class="navbar-nav">
                    <li class="nav-item mt-2">
                        <a @class([
                            'nav-link',
                            'active' => Route::currentRouteName() == 'admin.dashboard',
                        ]) aria-current="page" href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-house me-2 fs-5"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a @class([
                            'nav-link',
                            'active' => Route::currentRouteName() == 'admin.apartments.index',
                        ]) aria-current="page" href="{{ route('admin.apartments.index') }}">
                            <i class="fa-solid fa-building me-2 fs-5"></i>
                            <span>Appartamenti</span>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a @class([
                            'nav-link',
                            'active' => Route::currentRouteName() == 'admin.sponsorships.index',
                        ]) aria-current="page"
                            href="{{ route('admin.sponsorships.index') }}">
                            <i class="fa-solid fa-money-check-dollar me-2 fs-5"></i>
                            <span>Sponsorship</span>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a @class([
                            'nav-link',
                            // 'active' => Route::currentRouteName() == 'admin.messages.index',
                        ]) aria-current="page" href="#">
                            <i class="fa-solid fa-message me-2 fs-5"></i>
                            <span>Messaggi</span>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <div>

                        <li class="nav-item nav-link mt-2">
                            <a class="dropdown-item text-danger" href="{{ url('profile') }}">
                                <i class="fa-solid fa-trash-can me-2 fs-5"></i>
                                <span>Elimina Profilo</span>
                            </a>
                        </li>
                        <form action="{{ route('logout') }}" id="logout-form" method="POST">
                            @csrf
                            <li class="nav-item nav-link mt-2">
                                <button class="dropdown-item" href="{{ route('logout') }}" id="logout-link">
                                    <i class="fa-solid fa-right-from-bracket me-2 fs-5"></i>
                                    <span>Logout</span>
                                </button>
                            </li>
                        </form>
                    </div>
                </ul>
            </div>
        </div>
    </div>
@endsection
