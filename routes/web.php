<?php

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/{any}', function (): View {
    return view('welcome');
})->where('any', '^(?!api\/).*$');
