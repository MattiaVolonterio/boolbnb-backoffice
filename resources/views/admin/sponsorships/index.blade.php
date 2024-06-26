@extends('layouts.side-bar-layout')
@section('title', 'Sponsorizzazioni')

{{-- @push('css')
    <link rel="stylesheet" href="/../../../scss/sponsorships/sponsorships.scss">
@endpush --}}

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection


@section('content')
    <main>
        <div class="container py-4">
            {{-- titolo pagina --}}
            <h1 class=" text-center">Sponsorizza un Appartamento</h1>
            <h2 class=" mt-5 mx-xl-5 mx-xxl-0 mb-4">Seleziona il tuo piano</h2>
            <div class="row g-3 row-cols-1 row-cols-xxl-3 mx-xl-5 mx-xxl-0">
                {{-- generatore card sponsorizzazione --}}
                @forelse ($sponsorships as $sponsorship)
                    <div class="col">
                        {{-- single card --}}
                        <div class="card">
                            {{-- card-header --}}
                            <header class="card-header text-center">
                                {{-- nome sponsorizzazione --}}
                                <span class="fs-6">{{ $sponsorship->tier }}</span>
                            </header>
                            {{-- card-body --}}
                            <main class="card-body py-4 px-5">
                                {{-- prezzi della sponsorizzazione --}}
                                <h2 class="text-center fs-1"><span
                                        class="text-success">&euro;{{ $sponsorship->price }}</span><span
                                        class="fs-5">/{{ $sponsorship->duration }} ore</span>
                                </h2>
                                <p class="text-center">Sponsorizza il tuo appartamento per
                                    @if ($sponsorship->duration == 24)
                                        un giorno
                                    @elseif($sponsorship->duration == 72)
                                        tre giorni
                                    @else
                                        sei giorni
                                    @endif
                                </p>

                                <div class="mt-4">
                                    <h4 class="mb-2">Vantaggi:</h4>

                                    {{-- vantaggi della sponsorizzazione --}}
                                    <ul class="px-2 mt-3">
                                        <li class="d-flex gap-3 align-items-center mb-2">
                                            <i class="fa-solid fa-clock"></i>
                                            @if ($sponsorship->duration == 24)
                                                <span><strong>1 giorno</strong> di durata</span>
                                            @elseif($sponsorship->duration == 72)
                                                <span><strong>3 giorni</strong> di durata</span>
                                            @else
                                                <span><strong>6 giorni</strong> di durata</span>
                                            @endif
                                        </li>
                                        <li class="d-flex gap-3 align-items-start mb-2">
                                            <i class="fa-solid fa-star"></i>
                                            <span>Comparirai nella sezione in evidenza</span>
                                        </li>
                                        <li class="d-flex gap-3 align-items-start">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>Le visite sui tuoi appartamenti aumenteranno</span>
                                        </li>
                                    </ul>
                                    {{-- bottone che ci porta al form di selezione appartamento --}}
                                    <button class="btn btn-primary mt-4 text-capitalize" data-bs-toggle="modal"
                                        data-bs-target="#purchase-modal-{{ $sponsorship->id }}">acquista
                                        sponsorizzazione!</button>
                                </div>
                            </main>
                        </div>
                    </div>
                @empty
                    <h2 class="text-danger">Nessuna sponsorship trovata!</h2>
                @endforelse

            </div>
        </div>
    </main>
@endsection

@section('modal')
    @foreach ($sponsorships as $sponsorship)
        <!-- Modal -->
        <div class="modal fade" id="purchase-modal-{{ $sponsorship->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="GET" action="{{ route('admin.sponsorships.create') }}">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        {{-- titolo modale --}}
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Sponsorizzazione {{ $sponsorship->tier }}</h1>
                        {{-- bottone chiusura modale --}}
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    {{-- contenuto principale --}}
                    <div class="modal-body">
                        {{-- input nascosto relativo alla sponsorizzazione che si sta acquistando --}}
                        <input type="hidden" name="sponsorship_id" value="{{ $sponsorship->id }}">

                        {{-- selezione dell'appartamento da sponsorizzare --}}
                        <label class="form-label" for="apartment_id">Quale appartamento vuoi sponsorizzare?</label>
                        <select name="apartment_id" id="apartment_id" class="form-select">
                            <option class="d-none" selected>Seleziona un appartamento</option>
                            @forelse ($apartments as $apartment)
                                <option value="{{ $apartment->id }}">{{ $apartment->name }}</option>
                            @empty
                                <option>Nessun appartamento trovato</option>
                            @endforelse
                        </select>

                        {{-- paragrafo con il prezzo totale --}}
                        <p class="mt-2 mb-0 text-success">Il prezzo è di &euro;{{ $sponsorship->price }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                        @if (!empty($apartments))
                            <button type="submit" class="btn btn-primary">Vai al pagamento</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
