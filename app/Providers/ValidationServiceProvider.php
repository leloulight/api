<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Services\CurrencyService;

class ValidationServiceProvider extends ServiceProvider {

    public function boot() {
        
        $this->app['validator']->extend(
            'currency_code', function ($attribute, $value, $parameters) {
                $currency = new CurrencyService();
                return $currency->checkCurrency( $value );
            },
            'Invalid currency code'
            );
    }

    public function register() {
        //
    }
}