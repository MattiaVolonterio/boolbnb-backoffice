@extends('layouts.app-only-main')
@section('title', 'Login')

@section('css')

    @vite('resources/scss/login.scss')

@endsection

@section('content')

    <div class="login-container">

        <div class="main-container py-5">

            <h2 class="text-center mb-5 fw-bold">Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="container">

                    {{-- mail --}}
                    <div class="mb-4 row">
                        <div class="col-10 offset-1">
                            <label for="email"
                                class=" form-label text-md-right fw-bold">{{ __('Indirizzo E-Mail') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- password --}}
                    <div class="mb-4 row">
                        <div class="col-10 offset-1">
                            <label for="password"
                                class="col-4 form-label text-md-right fw-bold">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ricordami --}}
                <div class="mb-4 row">
                    <div class="col-11 d-flex justify-content-end pe-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Ricordami') }}
                            </label>

                            {{-- @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Password Dimenticata?') }}
                    </a>
                @endif --}}
                        </div>
                    </div>
                </div>

                {{-- Login button --}}
                <div class="mb-4 row justify-content-center px-3">
                    <div class="col-10">
                        <button type="submit" class="button-custom w-100">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>


                {{-- Registrati --}}
                <div class="text-center">
                    <a class="register-text" href="{{ route('register') }}">Non hai un'account? Registrati</a>
                    <div class="register-text">oppure</div>
                    <a class="register-text" href="http://localhost:5174/">Torna alla Homepage</a>
                </div>

            </form>
        </div>

    </div>
@endsection
