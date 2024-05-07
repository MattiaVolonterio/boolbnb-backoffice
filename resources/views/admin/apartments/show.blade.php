@extends('layouts.app')

@section('content')
    <section class="container py-3">

        
        <div class=" d-flex justify-content-between">
            {{-- back to index navigation button --}}
            <div>
                <button type="button" class="btn btn-primary me-3">
                    <i class="fa-solid fa-arrow-left me-1"></i>
                    <a href="{{ route('admin.apartments.index') }}" class="text-decoration-none text-white">
                        Torna alla lista
                    </a>
                </button>

                {{-- go to edit --}}
                <button type="button" class="btn btn-warning">
                    <a href="{{ route('admin.apartments.edit', $apartment->id) }}" class="text-decoration-none text-white">
                        Modifica
                    </a>
                </button>
            </div>
        </div>
        
        <h1 class="text-center mt-5">{{ $apartment->name }}</h1>
        <di class="row mt-4">
            <div class="col-md-6 col-12">
                <div class="d-flex justify-content-center">
                    {{-- img cover se nn ce img placeholder dal sito picsum --}}
                    <img src="{{ $apartment->cover_img ? asset( $apartment->cover_img) : 'https://picsum.photos/200/300' }}"
                     class="card-img-top card-image-character mb-2" alt="{{ $apartment->name }}">
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div><strong>Nome: </strong>{{$apartment->name}}</div>
                <div><strong>Stanze: </strong>stanze: {{$apartment->n_room}}</div>
                <div><strong>Bagni: </strong>{{$apartment->n_bathroom}}</div>
                <div><strong>Letti: </strong>{{$apartment->n_bed}}</div>
                <div><strong>Superficie: </strong>{{$apartment->square_meters}}</div>
                <div><strong>Piano: </strong>{{$apartment->floor}}</div>
                <div><strong>Indirizzo: </strong>{{$apartment->address}}</div>
                <div><strong>lat: </strong>{{$apartment->lat}}</div>
                <div><strong>lon: </strong>{{$apartment->lon}}</div>
                <div><strong>visibile: </strong>{{$apartment->visible}}</div>
                
            </div>
            <div class="col-md-3 col-6 overflow-auto">
                <h2 class="text-start">Servizi</h2>
                @foreach($services as $service)
                    @if ($apartment->services->contains($service->id))
                        <div class="form-check d-flex align-items-center p-0 " >
                            <div class="me-2"><img src="{{asset( $service->icon)}} "alt="" style="width: 30px;"></div>
                            <label class="form-check-label" for="service_{{ $service->id }}">
                                {{ $service->name }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>   
        </di>
        <div class="row my-5">

            <div class="col-md-6 col-12">
                <h2 class="mb-3">Immagini dell'appartamento</h2>

                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner ms_carousel-inner">
                        @foreach($apartment_images as $index => $apartment_image)
                            <div class="carousel-item ms_carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $apartment_image->url) }}" class="d-block w-100 h-100 object-fit-cover rounded-3" alt="Immagine mancante">
                            </div>
                        @endforeach
                    </div>

                    {{-- Sezione bottoni --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: #333;"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: #333;"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </div>
            
            <div class="col-6 text-center">
                {{-- <div> --}}
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-success">Vai ai messaggi</a>
                {{-- </div> --}}
            </div>

        </div>
    </section>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
         integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />    
@endsection