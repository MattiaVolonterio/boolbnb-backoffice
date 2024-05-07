@extends('layouts.app-only-main')
@section('title', 'Registrati')

@section('css')

    @vite('resources/scss/register.scss')

@endsection

@section('content')

    <div class="register-container">

        <div class="main-container pt-5">

            <h2 class="text-center  mb-5 fw-bold">Registrati</h2>


            <div class="card-body">
                <form id='form' method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nome --}}
                    <div class="mb-5 row gap-1 g-3">

                        <div class="col-10 col-md-5 offset-1">
                            <label for="name" class="form-label fw-bold">{{ __('Nome') }}</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        {{-- Cognome --}}


                        <div class="col-10 col-md-5 offset-1 offset-md-0">
                            <label for="surname" class="form-label fw-bold">{{ __('Cognome') }}</label>
                            <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                                name="surname" value="{{ old('surname') }}" autocomplete="surname" autofocus>

                            @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        {{-- Data di nascita --}}


                        <div class="col-10 col-md-5 offset-1">
                            <label for="birthday" class="form-label fw-bold">{{ __('Data di Nascita') }}</label>
                            <input id="birthday" type="date"
                                class="form-control @error('birthday') is-invalid @enderror" name="birthday"
                                value="{{ old('birthday') }}" autocomplete="birthday" autofocus>

                            @error('birthday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        {{-- Email --}}


                        <div class="col-10 col-md-5 offset-1 offset-md-0">
                            <label for="email" class="form-label fw-bold">Indirizzo
                                E-Mail<span class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        {{-- Password --}}


                        <div class="col-10 col-md-5 offset-1">
                            <label for="password" class="form-label fw-bold">Password<span
                                    class="text-danger">*</span></label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <span id="password-feedback" class="invalid-feedback" role="alert">
                            </span>
                        </div>


                        {{-- Conferma password --}}


                        <div class="col-10 col-md-5 offset-1 offset-md-0">
                            <label for="password-confirm" class="form-label fw-bold">Conferma
                                Password <span class="text-danger"> *</span></label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="mb-4 row mb-0 justify-content-center">
                        <div class="col-5">
                            <button type="submit" class="btn btn-primary  w-100" id="submit-button">
                                {{ __('Registrati') }}
                            </button>
                        </div>
                    </div>

                    <p class="pt-4 offset-1 text-danger fw-bold" style="font-size: 12px">* Questi campi sono obbligatori</p>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password-confirm');
        const passwordFeedback = document.getElementById('password-feedback')
        const submitButton = document.getElementById('submit-button');
        const form = document.getElementById('form');



        submitButton.addEventListener('click', function(event) {
            event.preventDefault();

            let password = passwordInput.value;
            let passwordConfirm = passwordConfirmInput.value;

            if (!password) {
                passwordFeedback.innerHTML = '<strong>La password non può essere vuota</strong>';
                passwordFeedback.classList.add('d-block');
            } else if (password.length <= 8) {
                passwordFeedback.innerHTML = '<strong>La password deve avere minimo 8 caratteri</strong>';
                passwordFeedback.classList.add('d-block');
            } else if (password != passwordConfirm) {
                passwordFeedback.innerHTML = '<strong>Le password inserite non corrispondono</strong>';
                passwordFeedback.classList.add('d-block');
            } else {
                form.submit();
            }
        })

        passwordInput.addEventListener('input', () => {
            passwordFeedback.classList.remove('d-block');
        })
    </script>
@endsection
