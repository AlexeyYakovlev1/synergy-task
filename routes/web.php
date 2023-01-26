<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/auth/registration', [UserController::class, 'registration_get']);
Route::get('/auth/login', [UserController::class, 'login_get']);
Route::get('/auth/check/{id}', [UserController::class, 'auth_check'])->name("users.auth.check");

Route::get('/profile/{id}', [UserController::class, 'profile_get'])->name("users.profile");

Route::post('/auth/login', [UserController::class, 'login'])->name("users.login");
Route::post('/auth/registration', [UserController::class, 'create'])->name("users.registration");