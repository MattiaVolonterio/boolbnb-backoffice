@php
    $gateway = config('gateway');
    $clientToken = $gateway->clientToken()->generate();
@endphp

@extends('layouts.app')
@section('title', 'pagamento')

@section('payment-js')
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <form id="payment-form" action="{{ route('admin.sponsorships.store', $payment_info) }}" method="post">
            @csrf
            <div id="dropin-container"></div>
            <button type="submit" class="btn btn-primary">Paga</button>
            <input type="hidden" id="nonce" name="payment_method_nonce">
        </form>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        const form = document.getElementById('payment-form');
        const clientTokenJS = "<?php echo $clientToken; ?>";

        braintree.dropin.create({
            authorization: clientTokenJS,
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
