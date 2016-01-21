<?php

use \Frog\FrogController;
use \Currency\CurrencyConverterController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Default page
Route::get('/', FrogController::class.'@index');

// Currency converter API
Route::get('currency', CurrencyConverterController::class.'@convertCurrency');
