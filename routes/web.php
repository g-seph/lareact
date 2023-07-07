<?php

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


// I know, I know, not the standard naming you expect. Listen... I immediately understand what a named rout is
// used for when I name them this way {name}.{page|action}
// page is used to name routes that are expected to return render a view
// action is used for generic api routes

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::get('/login', 'loginPage')->name('login.page');
    Route::post('/login', 'login')->name('login.action');
    Route::get('/register', 'registerPage')->name('register.page');
    Route::post('/register', 'register')->name('register.action');
    Route::get('/user-details', 'userDetails')->name('user.details.page');
    Route::post('/logout', 'logout')->name('user.logout.action');
});
