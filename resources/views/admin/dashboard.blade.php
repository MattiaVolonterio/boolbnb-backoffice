@extends('layouts.app')
@section('title', 'Dashbord')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('Benvenuto ' . Auth::user()->name) }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-5 col-lg-4 my-1 my-md-2">
                                <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary w-100">
                                    Inserisci un nuovo appartamento
                                </a>
                            </div>
                            <div class="col-md-5 col-lg-4 my-1 my-md-2">
                                <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary w-100">
                                    Gestisci i tuoi appartamenti
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
