<?php

namespace App\Providers;

use App\Contracts\AddressValidationResponse;
use Illuminate\Support\ServiceProvider;
use App\Contracts\AddressValidation;
use App\Contracts\Address;
use App\Services\AddressValidationCanada;
use App\Services\AddressValidationUSA;


class AddressServiceProvider extends ServiceProvider
{
    public $bindings = [
        'AddressValidationCanada' => AddressValidationCanada::class,
        'AddressValidationUSA' => AddressValidationUSA::class,
        'Address' => Address::class,
        'AddressValidationResponse' => AddressValidationResponse::class,

    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind('AddressValidationCanada',  \App\Services\AddressValidationCanada::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
