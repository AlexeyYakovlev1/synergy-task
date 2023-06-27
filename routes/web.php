<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix("/auth")->group(function() {
	Route::view("/login", "pages.login")->middleware("redirect_if_token_exist");
	Route::view("/registration", "pages.registration")->middleware("redirect_if_token_exist");

	Route::post("/login", [AuthController::class, "login"]);
	Route::post("/registration", [AuthController::class, "registration"]);
});

// User
Route::prefix("/user")->group(function() {
	Route::view("/{id}", "pages.user")->middleware("check_auth")->middleware("give_user_data");

	Route::post("/update/{id}", [UserController::class, "update"])->middleware("check_auth");
});
Route::view("/settings", "pages.settings")->middleware("data_if_token_exist");