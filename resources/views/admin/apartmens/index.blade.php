@extends('layouts.app')

@section('content')
    <section class="container mt-5">
        <h1 class="text-light text-center">Lista Appartamenti</h1>

        <a class="btn btn-primary mt-3 mb-4" href="{{ route('admin.apartments.create') }}">Crea uno nuovo</a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Stanze</th>
                    <th scope="col">Bagni</th>
                    <th scope="col">Metri Quadrati</th>
                    <th scope="col">Piano</th>
                    <th scope="col">Indirizzo</th>
                    <th scope="col">Lat</th>
                    <th scope="col">Lon</th>
                    <th scope="col">Cover</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($apartments as $apartment)
                    <tr>
                        <td>{{ $apartment->id }}</td>
                        <td>{{ $apartment->name }}</td>
                        <td>{{ $apartment->slug }}</td>
                        <td>{{ $apartment->n_room }}</td>
                        <td>{{ $apartment->n_bathroom }}</td>
                        <td>{{ $apartment->square_meters }}</td>
                        <td>{{ $apartment->floor }}</td>
                        <td>{{ $apartment->address }}</td>
                        <td>{{ $apartment->lat }}</td>
                        <td>{{ $apartment->lon }}</td>
                        <td>{{ $apartment->cover_img }}</td>
                        <td>
                            <a href="{{ route('admin.apartments.show', $apartment->id) }}" class=" text-decoration-none me-2">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.apartments.edit', $apartment->id) }}" class="me-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" class="modal-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-apartment-{{ $apartment->id }}">
                                <i class="fa-solid fa-circle-xmark" style="color: red;"> </i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12">Nessun appartamento trovato</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $apartments->links() }} 
    </section>
@endsection

@section('modal')
    @foreach ($apartments as $apartment)
        <div class="modal fade" id="delete-apartment-{{ $apartment->id }}" tabindex="-1"
             aria-labelledby="deleteApartmentLabel{{ $apartment->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteApartmentLabel{{ $apartment->id }}">Eliminare {{ $apartment->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Premendo elimina l'azione sarà irreversibile. Procedere?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                        <form action="{{ route('admin.apartments.destroy', $apartment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
         integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
