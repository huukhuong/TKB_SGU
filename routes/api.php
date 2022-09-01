<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('getTimeTableByStudentId/{id}', [WebController::class, 'getTimeTableByStudentId']);
