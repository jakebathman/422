<?php

use App\Http\Controllers\Test422Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'headers' => request()->headers->all(),
    ]);
});

Route::any('/test', Test422Controller::class)->name('test');
