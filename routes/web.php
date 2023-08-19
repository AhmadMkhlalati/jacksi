<?php

use App\Http\Controllers\Admin\NotificationContoller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix'=>'admin'],function (){
    Auth::routes([
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]);
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');

    Route::get('/send_notification/', [NotificationContoller::class, 'send_users'])->name('send.users.notification');
    Route::post('/send_notification/', [NotificationContoller::class, 'send_users_post'])->name('send.users.notification_post');

    Route::get('/send_notification/{id}', [NotificationContoller::class, 'send_user'])->name('send.user.notification');
    Route::post('/send_notification/{id}', [NotificationContoller::class, 'send_user_post'])->name('send.user.notification_post');

    Route::get('/notes', [App\Http\Controllers\Admin\NoteController::class, 'index'])->name('admin.notes.index');
    Route::get('/notes/create', [App\Http\Controllers\Admin\NoteController::class, 'create'])->name('admin.notes.create');
    Route::post('/notes/store', [App\Http\Controllers\Admin\NoteController::class, 'store'])->name('admin.notes.store');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');



