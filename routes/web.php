<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});



Route::match(['GET','POST'],'login',[ProfileController::class,'login'])->name('login');
Route::match(['GET','POST'],'register',[ProfileController::class,'register'])->name('register');
Route::get('logout',[ProfileController::class,'logout'])->name('logout');
Route::match(['GET','POST'],'dashboard',[ProfileController::class,'dashboard'])->name('dashboard');

Route::get('auth/google', [ProfileController::class,'redirectToGoogle'])->name('redirectToGoogle');
Route::get('auth/google/callback', [ProfileController::class,'handleGoogleCallback'])->name('handleGoogleCallback');
