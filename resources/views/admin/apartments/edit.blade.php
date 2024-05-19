@extends('layouts.side-bar-layout')
@section('title')
    {{ $apartment->name }}
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center text-primary my-3">{{ $apartment->name }}</h1>
        <a href="{{ route('admin.apartments.show', $apartment) }}" class="btn btn-primary mt-4 mb-3">Torna
            all'appartamento</a>
        <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary mt-4 mb-3">Torna alla lista</a>
        <div>

            <h2 class="mb-3">Modifica Appartamento</h2>
            <form action="{{ route('admin.apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @method('PATCH')

                <div class="d-flex align-items-center mb-3">
                    {{-- Switch --}}
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="visible" name="visible"
                            @if ($apartment->visible == 1) checked @endif>
                        <label class="form-check-label" for="visible">Visibile</label>
                    </div>

                    <div class="ms-3">
                        <button class="btn btn-success">Salva</button>
                    </div>
                </div>

                <div class="row g-5">
                    <div class="col-lg-6">
                        {{-- nome del appartamento  --}}
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $apartment->name) }}" required>
                            <label for="name" class="form-label z-0">Inserisci nome dell'appartamento<span
                                    class="text-danger"> * </span></label>
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
                                        class="form-control @error('n_room') is-invalid @enderror" id="n_room"
                                        name="n_room" value="{{ old('n_room', $apartment->n_room) }}" required>
                                    <label for="n_room" class="form-label z-0">Inserisci nr stanze<span
                                            class="text-danger"> *
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
                                        name="n_bathroom" value="{{ old('n_bathroom', $apartment->n_bathroom) }}" required>
                                    <label for="n_bathroom" class="form-label z-0">Inserisci nr bagni<span
                                            class="text-danger">
                                            * </span></label>
                                    @error('n_bathroom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                {{-- nr letti --}}
                                <div class="form-floating">
                                    <input type="number" min="1"
                                        class="form-control @error('n_bed') is-invalid @enderror" id="n_bed"
                                        name="n_bed" value="{{ old('n_bed', $apartment->n_bed) }}" required>
                                    <label for="n_bed" class="form-label z-0">Inserisci nr letti<span
                                            class="text-danger"> *
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
                                    <input type="number" class="form-control @error('floor') is-invalid @enderror"
                                        id="floor" name="floor" value="{{ old('floor', $apartment->floor) }}"
                                        required>
                                    <label for="floor" class="form-label z-0">Inserisci nr piano<span
                                            class="text-danger"> *
                                        </span></label>
                                    @error('floor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- nr superficie --}}
                            <div class="col-4">
                                <div class="form-floating">
                                    <input type="number" min="20"
                                        class="form-control @error('square_meters') is-invalid @enderror" id="square_meters"
                                        name="square_meters" value="{{ old('square_meters', $apartment->square_meters) }}"
                                        required>
                                    <label for="square_meters" class="form-label z-0">superfice (mq) <span
                                            class="text-danger">
                                            *
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
                                    <div class="col-12 mb-3 z-0">
                                        <div class="search-container form-floating">
                                            <input type="text" @class([
                                                'form-control',
                                                'is-invalid' =>
                                                    $errors->has('address') || $errors->has('lon') || $errors->has('lat'),
                                            ]) id="address"
                                                name="address" value="{{ old('address', $apartment->address) }}" required
                                                autocomplete="off">
                                            <label for="address" class="form-label">Indirizzo</label>
                                            <div id="suggestion"></div>
                                            @error('square_meters')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('lon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('lat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- latitude e longitude  solo per debug --}}
                                    <div class="col-6 d-none">
                                        <label for="" id="latitude" class="form-label"></label>
                                        <label for="" id="longitude" class="form-label"></label>
                                        <input type="hidden" id="lat" name="lat"
                                            value="{{ old('lat', $apartment->lat) }}">
                                        <input type="hidden" id="lon" name="lon"
                                            value="{{ old('lon', $apartment->lon) }}">
                                    </div>


                                </div>
                            </div>

                            {{-- cover img --}}
                            <div class="col mb-3">
                                <label for="cover_img" class="form-label mb-1 z-0">Carica
                                    la cover</label>
                                <input class="form-control  @error('cover_img') is-invalid @enderror" type="file"
                                    name="cover_img" id="cover_img">
                                @error('cover_img')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- servizi --}}
                            <div class="row g-3">

                                <h3 class="text-center text-primary">Servizi</h3>

                                <div class="col">

                                    <div @class([
                                        'is-invalid' => $errors->has('services'),
                                        'd-flex',
                                        'flex-column',
                                        'services-row',
                                        'flex-wrap',
                                        'align-content-between',
                                    ])>
                                        @foreach ($services as $service)
                                            <div class="form-check">
                                                <input @class(['is-invalid' => $errors->has('services'), 'form-check-input']) type="checkbox"
                                                    value="{{ $service->id }}" id="service_{{ $service->id }}"
                                                    name="services[]"
                                                    {{ in_array($service->id, old('services', $apartment->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="service_{{ $service->id }}">
                                                    {{ $service->name }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                    @error('services')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>
            </form>

            <div class="col-lg-6 pb-4 pb-lg-0">
                @if (!empty($apartment->cover_img))
                    <div class="card">
                        <img src="{{ asset('storage/uploads/cover/' . $apartment->cover_img) }}"
                            class="card-img-top img-fluid rounded" style="width: 100%; height: auto;"
                            alt="apartment cover img" style="width: 200px;">
                    </div>
                @endif

                {{-- edit carousel --}}
                <div class="row g-1 mt-3">
                    {{-- foreach --}}
                    @foreach ($apartment_images as $img)
                        {{-- apartment imgs --}}
                        <div class="col-4">
                            <div class="card" style="height: 100px;">
                                {{-- form delete --}}
                                <form action="{{ route('admin.apartment-images.destroy', $img) }} " method="POST"
                                    id="{{ $img->id }}" class=" h-100">
                                    @csrf
                                    @method('DELETE')


                                    <button
                                        class="delete-image-button btn btn-danger position-absolute rounded-circle ms-1 mt-1"
                                        id="{{ $img->id }}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                    <img src="{{ $img->url ? asset('storage/uploads/apartment_images/' . $img->url) : '' }}"
                                        style="width: 100%; height: 100%;" class="card-img-top img-fluid m-0 rounded"
                                        alt="" id="newImage">
                                </form>
                            </div>
                        </div>
                    @endforeach

                    @if (count($apartment_images) < 9)
                        <div class="col-4">
                            <div class="card d-flex justify-content-center bg-body-secondary"
                                style="height: 100px; width:auto;">

                                {{-- add files card --}}
                                <div class="text-center">
                                    <div>
                                        <label for="apartment_images" style="cursor:pointer;">
                                            <i class="fa-solid fa-plus text-white rounded-circle p-3 bg-secondary"></i>
                                        </label>
                                        {{-- add files input --}}
                                        <input type="file" id="apartment_images" name="apartment_images[]" multiple
                                            hidden>
                                    </div>
                                </div>
                                @error('apartment_images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="text-center">
                                    {{-- files counter --}}
                                    <span id="files"></span>
                                </div>

                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>


    </div>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite('resources/scss/ap-edit.scss')
@endsection
@section('js')
    @vite('resources/js/input-edit.js')
@endsection
