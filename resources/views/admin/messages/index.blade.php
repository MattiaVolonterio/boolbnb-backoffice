@extends('layouts.side-bar-layout')
@section('title', 'Messaggi')

@section('content')
    <section class="container mt-3">
        <h1 class="my-4">Messaggi ricevuti</h1>

        <div class="card-body messages-body">
            @foreach ($messages as $message)
                <div for class="accordion d-flex z-0 gap-3 align-items-center" id="accordionFlushExample">
                    <div class="accordion-item z-0 flex-grow-1">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-{{ $message['id'] }}" aria-expanded="false"
                                aria-controls="flush-{{ $message['id'] }}">
                                {{ $message['customer_email'] }} -
                                {{ $message['name'] }} -
                                {{ $message['apartment']['name'] }} -
                                {{ $message['created_at'] }}
                            </button>
                        </h2>
                        <div id="flush-{{ $message['id'] }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">{{ $message['content'] }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#delete-message-{{ $message['id'] }}">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            @endforeach
        </div>


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
