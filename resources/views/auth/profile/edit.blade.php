@extends('layouts.side-bar-layout')
@section('title', 'Elimina Account')

@section('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Elimina Profilo') }}
        </h2>
        {{-- <div class="card p-4 mb-4 bg-white shadow rounded-lg">

      @include('auth.profile.partials.update-profile-information-form')

    </div> --}}

        {{-- <div class="card p-4 mb-4 bg-white shadow rounded-lg">


      @include('auth.profile.partials.update-password-form')

    </div> --}}

        <div class="card p-4 mb-4 bg-white shadow rounded-lg">


            @include('auth.profile.partials.delete-user-form')

        </div>
    </div>
@endsection
