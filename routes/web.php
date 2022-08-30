<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WebController;

Route::get('/', [WebController::class, 'index']);
Route::post('timetable', [WebController::class, 'timetable']);

Route::get('login', [AdminController::class, 'getLogin'])->name('login');;
Route::post('login', [AdminController::class, 'postLogin']);

Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'saveMaintainConfig']);
    Route::get('/logout', [AdminController::class, 'logout']);

    Route::get('/students', [AdminController::class, 'student']);
    Route::post('/students', [AdminController::class, 'searchStudent']);


    Route::get('/lectures', [AdminController::class, 'lecture']);
    Route::post('/lectures', [AdminController::class, 'addLecture']);

    Route::get('/skips', [AdminController::class, 'skip']);
    Route::get('/skips/delete/{id}', [AdminController::class, 'deleteSkip']);
    Route::post('/skips', [AdminController::class, 'addSkip']);

    Route::get('/blocks', [AdminController::class, 'block']);
    Route::get('/blocks/delete/{id}', [AdminController::class, 'deleteBlock']);
    Route::post('/blocks', [AdminController::class, 'addBlock']);

    Route::get('/notifications', [AdminController::class, 'notification']);
    Route::get('/notifications/delete/{id}', [AdminController::class, 'deleteNotification']);
    Route::get('/notifications/add', [AdminController::class, 'addNotification']);
    Route::post('/notifications/add', [AdminController::class, 'createNotification']);
});


Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');
