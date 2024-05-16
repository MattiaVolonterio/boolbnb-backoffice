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
            <ul class="navbar-nav">
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
                    ]) aria-current="page" href="{{ route('admin.apartments.index') }}">
                        <div class="d-flex d-lg-block justify-content-center">
                            <i class="fa-solid fa-building ms-lg-1 me-lg-2 mt-lg-1 fs-5"></i>
                            <span class="d-none d-lg-inline-block ms-1">Appartamenti</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item ">
                    <a @class([
                        'nav-link',
                        'active' => Route::currentRouteName() == 'admin.sponsorships.index',
                    ]) aria-current="page" href="{{ route('admin.sponsorships.index') }}">
                        <div class="d-flex d-lg-block justify-content-center">
                            <i class="fa-solid fa-money-check-dollar me-lg-2 mt-lg-1 fs-5"></i>
                            <span class="d-none d-lg-inline-block">Sponsorship</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item ">
                    <a @class([
                        'nav-link',
                        'active' => Route::currentRouteName() == 'admin.messages.index',
                    ]) aria-current="page" href="{{ route('admin.messages.index') }}">
                        <div class="d-flex d-lg-block justify-content-center">
                            <i class="fa-solid fa-message me-lg-2 mt-lg-1 fs-5"></i>
                            <span class="d-none d-lg-inline-block">Messaggi</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        {{-- gestione account --}}
        <div class="mt-auto">
            <li class="nav-item justify-content-center d-lg-block ms-lg-5 mb-3">
                <a class="nav-link" href="http://localhost:5174/">
                    <div class="d-flex d-lg-block justify-content-center">
                        <i class="fa-regular fa-square-caret-left me-lg-3 mt-lg-1 fs-5"></i>
                        <span class="d-none d-lg-inline-block">Sito Principale</span>
                    </div>
                </a>
            </li>


            <li class="nav-item nav-link dropdown-center" data-bs-theme="dark">
                <a aria-expanded="false" aria-haspopup="true"
                    class="nav-link d-flex justify-content-center d-lg-block ms-lg-5" data-bs-toggle="dropdown"
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

{{-- Offcanvas show --}}
<div class="offcanvas offcanvas-end show-fade" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
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
                    ]) aria-current="page" href="{{ route('admin.sponsorships.index') }}">
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
