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

// Auth
Route::prefix("auth")->group(function () {
	Route::get('/registration', [UserController::class, 'registration_get']);
	Route::get('/login', [UserController::class, 'login_get']);
	Route::get('/check/{id}', [UserController::class, 'auth_check'])
		->name("users.auth.check")
		->middleware("checkToken");
	Route::post('/login', [UserController::class, 'login'])->name("users.login");
	Route::post('/registration', [UserController::class, 'create'])->name("users.registration");
});

// Profile
Route::get('/profile/{id}', [UserController::class, 'profile_get'])
	->name("users.profile");
Route::get('/settings/{id}', [UserController::class, 'settings_get'])
	->name("users.settings");

// Api profile
Route::prefix("api")->group(function () {
	Route::put('/user/change/{id}', [UserController::class, 'profile_change'])
		->middleware("checkToken");
});