@extends('layouts.app')

@section('content')
<form action="{{ route('admin.apartments.store') }}" method="POST" class="container" id="form">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="row">
            <div class="col-6 mb-3">
                <label for="n_room" class="form-label">Numero di Stanze</label>
                <input type="number" class="form-control" id="n_room" name="n_room">
            </div>
            <div class="col-6 mb-3">
                <label for="n_bathroom" class="form-label">Numero di Bagni</label>
                <input type="number" class="form-control" id="n_bathroom" name="n_bathroom">
            </div>
        </div>


        <div class="mb-3">
            <label for="square_meters" class="form-label">Metri Quadrati</label>
            <input type="number" class="form-control" id="square_meters" name="square_meters">
        </div>

        <div class="mb-3">
            <label for="floor" class="form-label">Piano</label>
            <input type="text" class="form-control" id="floor" name="floor">
        </div>

        <button  class="btn btn-primary">Salva</button>
       

        

        {{-- ricerca indirizzo --}}
        <div class="row">

            {{-- indirizzo --}}
            <div class="col-10">
                <div class="search-container">
                    <label for="address" class="form-label">Indirizzo</label>
                    <input type="text" class="form-control" id="address" name="address" />
                    <div id="suggestion"></div>
                </div>
            </div>

            {{-- <div class="col-2 d-flex">
                <div id="search_btn" class="btn btn-primary align-self-end w-100">Cerca</div>
            </div> --}}
            <div><input type="checkbox" name="visible" checked> Visible</div>

            {{-- latitude e longitude --}}
            <div class="col-6 my-3">
                <input type="hidden" id="lat" name="lat" value="">
                <span id="latitude">Lat</span>
            </div>

            <div class="col-6 my-3">
                <input type="hidden" id="lon" name="lon" value="">
                <span id="longitude">Lon</span>
            </div> 

        </div>


        <button type="submit" class="btn btn-primary mt-2">Salva</button>
    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
   @vite('resources/js/input.js')
@endsection

