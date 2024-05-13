@extends('layouts.side-bar-layout')
@section('title', 'Appartamenti')

@section('content')
    @if (session('message-text'))
        <div class="alert {{ session('message-status') }} alert-dismissible fade show container mt-5" role="alert">
            {{ session('message-text') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="container mt-5" id="index-apartment">
        <h1 class="text-center">Lista Appartamenti</h1>

        <a class="btn btn-primary mt-3" href="{{ route('admin.apartments.create') }}">Crea uno nuovo</a>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-5 g-md-3 py-4">
            @forelse ($apartments as $apartment)
                <div class="col">
                    <div class="card h-100">
                        <a href="{{ route('admin.apartments.show', $apartment) }}">
                            <img src="{{ asset('storage/uploads/cover/' . $apartment->cover_img) }}" alt="apartment image"
                                class="card-img-top">
                        </a>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h2 class="card-title mb-2 h4 fw-semibold text-primary">{{ $apartment->name }}</h2>
                            {{-- TODO sistemare con valore reale --}}
                            <p>Numero visite: 55</p>
                            {{-- Switch --}}
                            <form class="form-check form-switch mb-4"
                                action="{{ route('admin.apartments.switch-visibility', $apartment) }}"
                                id="form-visible-{{ $apartment->id }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="visible-{{ $apartment->id }}" name="visible"
                                    @if ($apartment->visible == 1) checked @endif>
                                <label class="form-check-label" for="visible" id="label-visible-{{ $apartment->id }}">
                                    {{ $apartment->visible == 1 ? 'Visibile' : 'Non visibile' }} </label>
                            </form>

                            <div class="d-flex justify-content-between">

                                <a href="{{ route('admin.apartments.show', $apartment->id) }}"
                                    class="text-decoration-none btn btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                    Dettagli
                                </a>

                                <a href="{{ route('admin.apartments.edit', $apartment) }}" class="btn btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Modifica
                                </a>

                                <button class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-apartment-{{ $apartment->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">Nessun appartamento</div>
            @endforelse
        </div>



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
                        <h5 class="modal-title" id="deleteApartmentLabel{{ $apartment->id }}">Eliminare
                            {{ $apartment->name }}</h5>
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

    <link rel="stylesheet" href="../../../scss/app.scss">
@endsection

@section('js')
    <script>
        const visibleSwitches = document.querySelectorAll('.form-check-input');
        const visibleForm = document.getElementById('visibility-form');

        visibleSwitches.forEach(element => {
            element.addEventListener('click', () => {
                const switchId = element.getAttribute('id')
                const form = document.getElementById("form-" + switchId)
                form.submit();
            })
        });
    </script>
@endsection
