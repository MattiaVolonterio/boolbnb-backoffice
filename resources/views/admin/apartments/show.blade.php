@extends('layouts.app')

@section('content')
    <section class="container py-3">

        {{-- back to index navigation button --}}
        <button type="button" class="btn btn-primary">
            <a href="{{ route('admin.apartments.index') }}" class="text-decoration-none text-white">
                Torna alla lista
            </a>
        </button>
        {{$apartment_images[0]->url}}
        <h1 class="text-center m-3">{{ $apartment->name }}</h1>
        <di class="row my-3">
            <div class="col-6">
                <div class="d-flex justify-content-center">
                    {{-- img cover se nn ce img placeholder dal sito picsum --}}
                    <img src="{{ $apartment->cover_img ? asset( $apartment->cover_img) : 'https://picsum.photos/200/300' }}"
                     class="card-img-top card-image-character" alt="{{ $apartment->name }}">
                </div>
            </div>
            <div class="col-4">
                <div><strong>Nome: </strong> {{$apartment->name}}</div>
                <div><strong>Stanze: </strong>stanze: {{$apartment->n_room}}</div>
                <div><strong>Bagni: </strong> {{$apartment->n_bathroom}}</div>
                <div><strong>Letti: </strong> {{$apartment->n_bed}}</div>
                <div><strong>Superficie: </strong> {{$apartment->square_meters}}</div>
                <div><strong>Piano: </strong> {{$apartment->floor}}</div>
                <div><strong>Indirizzo: </strong>{{$apartment->address}}</div>
                <div><strong>lat: </strong>{{$apartment->lat}}</div>
                <div><strong>lon: </strong>{{$apartment->lon}}</div>
                <div><strong>visibile: </strong>{{$apartment->visible}}</div>
                
            </div>
            <div class="col-2 overflow-auto" style="height: 360px">
                <h2 class="text-start">servizi</h2>
                @foreach($services as $service)
                    @if ($apartment->services->contains($service->id))
                        <div class="form-check d-flex align-items-center p-0 " >
                            <div class="me-2"><img src="{{asset( $service->icon)}} "alt="" style="width: 30px"></div>
                            <label class="form-check-label" for="service_{{ $service->id }}">
                                {{ $service->name }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>   
        </di>
        <div class="row my-5">
            <h1>carosello</h1>
            <div class="col-6">
                <img src="{{ asset($apartment_images->url) }}" class="card-img-top card-image-character" alt="">
            </div>
            
        </div>
    </section>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
         integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />    
@endsection