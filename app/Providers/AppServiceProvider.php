<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        $gateway = new \Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'pgvg9khjz36kdwp7',
            'publicKey' => 'yfjx94gz4m3qwcpr',
            'privateKey' => '77642c6a5583a788d2000ce2213dd631'
        ]);
        config(['gateway' => $gateway]);
    }
}
