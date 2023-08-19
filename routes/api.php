<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::delete('logout', 'logout');
    Route::post('refresh', 'refresh');
});
Route::group(['middleware'=>'auth:api'],function (){
    Route::controller(NoteController::class)->group(function () {
        Route::get('notes', 'index');
        Route::get('notes/admin', 'index_admin');

        Route::post('note', 'store');
        Route::get('note/{id}', 'edit');
        Route::delete('note', 'delete');
        Route::post('note/update', 'update');
    });

});
