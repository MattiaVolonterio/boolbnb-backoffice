@extends('layouts.app')

@section('content')
    <form action="" method="POST" class="container" id="form">
    @csrf

    <label for="name" class="form-label">Nome</label>
    <input type="text" class="form-control" id="name" name="name" />

    <label for="number" class="form-label">N°</label>
    <input type="text" class="form-control" id="number" name="number" />

    <label for="type" class="form-label">Tipo</label>
    <select class="form-select" id="type" name="type">
        <option value="lunga">Lunga</option>
        <option value="corta">Corta</option>
        <option value="cortissima">Cortissima</option>
    </select>

    <label for="weight" class="form-label">Peso (g)</label>
    <input type="text" class="form-control" id="weight" name="weight" />

    <label for="img" class="form-label">img</label>
    <input type="text" class="form-control" id="img" name="img" />

    <label for="description" class="form-label">Descrizione</label>
    <textarea
        class="form-control"
        id="description"
        name="description"
        rows="4"
    ></textarea>

    {{-- ricerca indirizzo --}}
    <div class="row">

        {{-- indirizzo --}}
        <div class="col-10">
            <label for="address" class="form-label">Indirizzo</label>
            <input type="text" class="form-control" id="address" name="address" />
        </div>

        <div class="col-2 d-flex">
            <div id="search_btn" class="btn btn-primary align-self-end w-100">Cerca</div>
        </div>

        {{-- latitude e longitude --}}
        <div class="col-6">
            <input type="hidden" id="lat" name="lat" value="">
            <span id="latitude">Lat</span>
        </div>

        <div class="col-6">
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