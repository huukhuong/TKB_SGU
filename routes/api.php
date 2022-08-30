<?php

use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('getTimeTableByStudentId/{id}', function () {
    return Block::all();
});