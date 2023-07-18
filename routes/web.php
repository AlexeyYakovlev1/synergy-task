<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// AUTH
Route::prefix("/auth")->group(function() {
	Route::view("/login", "pages.login")->middleware("redirect_if_token_exist");
	Route::view("/registration", "pages.registration")->middleware("redirect_if_token_exist");

	Route::post("/login", [AuthController::class, "login"]);
	Route::post("/registration", [AuthController::class, "registration"]);
});

// USER
Route::prefix("/user")->group(function() {
	Route::view("/{id}", "pages.user")->middleware("check_auth")->middleware("give_user_data");

	Route::post("/update/{id}", [UserController::class, "update"])->middleware("check_auth");
});
Route::view("/settings", "pages.settings")->middleware("data_if_token_exist");

// POST
Route::prefix("/post")->group(function() {
	Route::post("/create", [PostController::class, "create"])->middleware("check_auth");
	Route::post("/update/{id}", [PostController::class, "update"])->middleware("check_auth");
	
	Route::delete("/delete/{id}", [PostController::class, "remove"])->middleware("check_auth");

	Route::get("/specific/{id}", [PostController::class, "get_one"]);
	Route::get("/all/{id}", [PostController::class, "get_by_user_id"]);
});
Route::get("/edit/{id}", [PostController::class, "view_edit"])->middleware("check_auth");
Route::get("/create", [PostController::class, "view_create"])->middleware("check_auth");