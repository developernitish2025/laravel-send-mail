<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// routes/web.php
Route::get('/contact', [ContactController::class, 'showForm']);
Route::post('/contact/submit', [ContactController::class, 'submitForm']);
Route::get('/', function () {
    return view('welcome');
});
