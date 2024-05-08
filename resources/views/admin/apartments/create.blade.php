@extends('layouts.app')

@section('content')
    {{-- <form action="{{ route('admin.apartments.store') }}" method="POST" class="container" id="form">
        @csrf   </form> --}}

    <div class="container ">

        <form class="mt-5" action="{{ route('admin.apartments.store', $apartment) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <h1 class="mb-3">Creazione Appartamento</h1>
            <div class="row g-5">
                <div class="col-6">
                    {{-- nome del appartamento  --}}
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        <label for="name" class="form-label">Inserisci Nome del Appartamento<span class="text-danger"> *
                            </span></label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- camere   --}}
                    <div class="row mb-3">
                        {{--  nr stanze  --}}
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="number" min="1"
                                    class="form-control @error('n_room') is-invalid @enderror" id="n_room" name="n_room"
                                    value="{{ old('n_room') }}" required>
                                <label for="n_room" class="form-label">Inserisci nr stanze<span class="text-danger"> *
                                    </span></label>
                                @error('n_room')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            {{-- nr bagni --}}
                            <div class="form-floating">
                                <input type="number" min="1"
                                    class="form-control @error('n_bathroom') is-invalid @enderror" id="n_bathroom"
                                    name="n_bathroom" value="{{ old('n_bathroom') }}" required>
                                <label for="n_bathroom" class="form-label">Inserisci nr bagni<span class="text-danger"> *
                                    </span></label>
                                @error('n_bathroom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            {{-- nr letti --}}
                            <div class="form-floating">
                                <input type="number" min="1"
                                    class="form-control @error('n_bed') is-invalid @enderror" id="n_bed" name="n_bed"
                                    value="{{ old('n_bed') }}" required>
                                <label for="n_bed" class="form-label">Inserisci nr letti<span class="text-danger"> *
                                    </span></label>
                                @error('n_bed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- piano e superficie  --}}
                    <div class="row mb-3">
                        {{-- nr piano --}}
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="number"
                                    min="1"class="form-control @error('floor') is-invalid @enderror" id="floor"
                                    name="floor" value="{{ old('floor') }}" required>
                                <label for="floor" class="form-label">Inserisci nr piano<span class="text-danger"> *
                                    </span></label>
                                @error('floor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- nr superficie --}}
                        <div class="col-4">
                            <div class="form-floating">
                                <input type="number" min="1" max="255"
                                    class="form-control @error('square_meters') is-invalid @enderror" id="square_meters"
                                    name="square_meters" value="{{ old('square_meters') }}" required>
                                <label for="square_meters" class="form-label">superfice (mq) <span class="text-danger"> *
                                    </span></label>
                                @error('square_meters')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    {{-- indirizzo e servizzi  --}}
                    <div class="row mb-3">

                        <div class="col-12">
                            <div class="row">

                                {{-- indirizzo --}}
                                <div class="col-12 mb-3 z-1">
                                    <div class="search-container form-floating">
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address" value="{{ old('address') }}" required>
                                        <label for="address" class="form-label">Indirizzo</label>
                                        <div id="suggestion"></div>
                                    </div>
                                </div>

                                {{-- latitude e longitude  solo per debug --}}
                                <div class="col-6 d-none">
                                    <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                                    <input type="hidden" id="lon" name="lon" value="{{ old('lon') }}">
                                </div>
                            </div>
                        </div>
                        {{-- Upload Foto --}}
                        <div class="col mb-3">
                            <label for="cover_img" class="form-label mb-1">Carica la cover</label>
                            <input class="form-control @error('cover_img') is-invalid @enderror" type="file"
                                name="cover_img" id="cover_img">
                        </div>
                        <div class="mb-3">
                            <label for="apartment_images" class="form-label mb-1">*Carica altre foto</label>
                            <input class="form-control @error('apartment_images') is-invalid @enderror" type="file"
                                id="apartment_images" name="apartment_images[]" multiple>
                        </div>

                        {{-- servizi --}}
                        <div class="row ">

                        </div>
                        {{-- Switch --}}
                        <div class="form-check form-switch m-3">
                            <input class="form-check-input @error('visible') is-invalid @enderror" type="checkbox"
                                role="switch" id="visible" name="visible" value="on">
                            <label class="form-check-label" for="visible">Visibile</label>
                        </div>

                        <div class="col-2">
                            <button class="btn btn-success">Salva</button>
                        </div>
                    </div>

                </div>

                <div class="col-6">
                    <h3 class="text-center text-primary mb-3">Aggiungi Servizi</h3>
                    <div class="row">
                        @foreach ($services as $service)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('services') is-invalid @enderror"
                                        type="checkbox" value="{{ $service->id }}" id="service_{{ $service->id }}"
                                        name="services[]" {{ in_array($service->id, old('services')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="service_{{ $service->id }}">
                                        {{ $service->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    @vite('resources/js/input.js')
@endsection
