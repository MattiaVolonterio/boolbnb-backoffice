@extends('layouts.app')

@section('content')
  <section class="container mt-3">
    <h1>Index dei messaggi</h1>

    <table class="table">
      <thead>
          <tr>
              <th scope="col">Indirizzo email</th>
              <th scope="col">Nome</th>
              <th scope="col">Testo</th>
          </tr>
      </thead>
      <tbody>

        @forelse ($messages as $message)
        <tr>
          {{-- <td>{{ $message->id }}</td> --}}
          {{-- @if($message->apartment_id == 23 )  --}}
              <td>{{ $message->customer_email }}</td>
              <td>{{ $message->name }}</td>
              <td>{{ $message->content }}</td>
          {{-- @endif --}}
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

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../../../scss/app.scss">
@endsection