<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

route::controller(QuoteController::class)->group(function(){
    route::get('/', 'testing')->name('testing');
    route::post('/calculate', 'calculate')->name('calculate');
});


