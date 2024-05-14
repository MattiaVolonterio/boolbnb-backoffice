@extends('layouts.side-bar-layout')
@section('title', 'Messaggi')

@section('content')
    <section class="container mt-3">
        <h1>Messaggi ricevuti</h1>

        <table class="table mt-5" style="border: 1px solid #e9e9e9">
            <thead>
                <tr>
                    <th scope="col">Indirizzo email</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Testo</th>
                    <th scope="col">Appartamento</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($messages as $message)
                    <tr>
                        <td>{{ $message['customer_email'] }}</td>
                        <td>{{ $message['name'] }}</td>
                        <td>{{ $message['content'] }}</td>
                        <td>{{ $message['apartment']['name'] }}</td>
                        <td>
                            <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#delete-message-{{ $message['id'] }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Nessun messaggio trovato</td>
                    </tr>
                @endforelse


            </tbody>
        </table>

    </section>
@endsection

@section('modal')
    @foreach ($messages as $message)
        <div class="modal fade" id="delete-message-{{ $message['id'] }}" tabindex="-1"
            aria-labelledby="deleteMessageLabel{{ $message['id'] }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteMessageLabel{{ $message['id'] }}">Elimina il messaggio di
                            {{ $message['name'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Premendo "Elimina" l'azione sarà irreversibile. Procedere?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                        <form action="{{ route('admin.messages.destroy', $message['id']) }}" method="POST">
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
