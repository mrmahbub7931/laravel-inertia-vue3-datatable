<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/contacts',[ContactController::class, 'index'])->name('contacts');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('home');

