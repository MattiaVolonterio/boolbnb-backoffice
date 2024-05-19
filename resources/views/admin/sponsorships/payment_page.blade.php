@extends('layouts.app-only-main')
@section('title', 'pagamento')

@section('payment-js')
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>
@endsection

@section('content')
    <div class="wrapper d-flex flex-column gap-3">
        <div class="link-container">
            <a href="{{ route('admin.sponsorships.index') }}" class="btn btn-primary">Torna a Sponsorships</a>
        </div>
        <div class="container">
            <div class=" row justify-content-lg-center">
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h5 text-center">Dettagli acquisto</h1>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-xl-6">
                                    <ul class=" list-unstyled">
                                        <li class="mb-2">Nome dell'appartamento:<br> <span
                                                class="fw-semibold ps-2">{{ $apartment->name }}</span></li>
                                        <li class="mb-2">Sponsorizzazione richiesta:<br> <span
                                                class="fw-semibold ps-2">{{ $sponsor->tier }}</span></li>
                                        <li class="mb-2">Durata: <br> <span
                                                class="fw-semibold ps-2">{{ $sponsor->duration }}
                                                ore</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <ul class=" list-unstyled">
                                        <li class="mb-2">Data Inizio: <br> <span
                                                class="fw-semibold ps-2">{{ $start_date }}</span>
                                        </li>
                                        <li class="mb-2">Data Fine:<br> <span
                                                class="fw-semibold ps-2">{{ $end_date }}</span>
                                        </li>
                                        <li class="mb-2">Prezzo: <br> <span class="fw-semibold ps-2">{{ $sponsor->price }}
                                                &euro;</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-xl-8">
                    <form id="payment-form" action="{{ route('admin.sponsorships.store') }}" method="post">
                        @csrf
                        <div id="dropin-container" class="m-0"></div>
                        @error($errors->any())
                            <div class="invalid-feedback">
                                @foreach ($errors as $error)
                                    {{ $error }}<br />
                                @endforeach
                            </div>
                        @enderror
                        <button type="submit" class="btn btn-primary">Paga</button>
                        <input type="hidden" id="nonce" name="payment_method_nonce">
                        <input type="hidden" id="apartment_id" name="apartment_id" value="{{ $apartment->id }}">
                        <input type="hidden" id="sponsorship_id" name="sponsorship_id" value="{{ $sponsor->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    @vite('resources/scss/sponsorships/payment.scss')
@endsection

@section('js')
    <script type="text/javascript">
        const form = document.getElementById('payment-form');
        braintree.dropin.create({
            authorization: "{{ env('BT_TOKENIZATION_KEY') }}",
            container: document.getElementById('dropin-container'),
        }, (error, dropinInstance) => {
            if (error) console.error(error);

            form.addEventListener('submit', event => {
                event.preventDefault();

                dropinInstance.requestPaymentMethod((error, payload) => {
                    if (error) console.error(error);

                    // Step four: when the user is ready to complete their
                    //   transaction, use the dropinInstance to get a payment
                    //   method nonce for the user's selected payment method, then add
                    //   it a the hidden field before submitting the complete form to
                    //   a server-side integration
                    document.getElementById('nonce').value = payload.nonce;
                    form.submit();
                });
            });
        });
    </script>
@endsection
