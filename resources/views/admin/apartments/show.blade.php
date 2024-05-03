@extends('layouts.app')

@section('content')
    <section class="container py-3">
        <h1 class="text-center">{{ $apartment->name }}</h1>
        <di class="row">
            <div class="col-4">
                <div class="d-flex justify-content-center">
                    {{-- img cover se nn ce img placeholder dal sito picsum --}}
                    <img src="{{ $apartment->cover_img ? asset($apartment->cover_img) : 'https://picsum.photos/200/300' }}"
                     class="card-img-top card-image-character" alt="{{ $apartment->name }}">
                </div>
            </div>
        </di>
    </section>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
         integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
         crossorigin="anonymous" referrerpolicy="no-referrer" />    
@endsection