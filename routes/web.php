<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('homepage');
});

Route::get('login', [AdminController::class, 'getLogin'])->name('login');;
Route::post('login', [AdminController::class, 'postLogin']);

Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/logout', [AdminController::class, 'logout']);
});