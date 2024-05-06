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
        <div id="dropin-container"></div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        const clientTokenJS = "<?php echo $clientToken; ?>";

        braintree.dropin.create({
            authorization: clientTokenJS,
            container: document.getElementById('dropin-container'),
        }, (error, dropinInstance) => {});
    </script>
@endsection
