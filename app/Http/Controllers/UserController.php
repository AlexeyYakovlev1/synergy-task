<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
	protected $table = "users";

	public function registration_get() {
		return view("auth.registration", [
			"title" => "Страница регистрации"
		]);
	}

	public function login_get() {
		return view("auth.login", [
			"title" => "Страница входа"
		]);
	}

	public function profile_get($id) {
		$find_user = User::where("id", $id)->first();

		return view("profile", [
			"title" => "Страница профиля",
			"user" => $find_user
		]);
	}

	public function auth_check($id) {
		$find_user = User::where("id", $id)->first();
		
		if ($find_user === null) {
			return response()->json([
				"success" => false
			]);
		}

		return response()->json([
			"success" => true,
			"user" => $find_user
		]);
	}

	public function login(Request $request) {
		$data = $request->validate([
			"email" => "required|string|email",
			"password" => "required|min:20|max:20"
		]);

		$email = $data["email"];
		$find_user = User::where("email", $email)->first();

		// если пользователь не найден
		if ($find_user === null) {
			return response()->json([
				"success" => false,
				"message" => "Такого пользователя не существует"
			]);
		}

		$password = $data["password"];
		$decode_password = Hash::check($password, $find_user["password"]);

		// проверка пароля
		if ($decode_password === null) {
			return response()->json([
				"success" => false,
				"message" => "Данные неверны"
			]);
		}
		
		return response()->json([
			"success" => true,
			"message" => "Успешный вход",
			"user" => $find_user
		]);
	}

	public function create(Request $request) {
		$data = $request->validate([
			"first_name" => "required|min:2|max:25",
			"last_name" => "required|min:2|max:30",
			"patronymic" => "required|min:2|max:50",
			"email" => "required|string|email",
			"password" => "required|min:20|max:20",
			"passport_series" => "required|min:4|max:4",
			"passport_id" => "required|min:6|max:6"
		]);

		$email = $data["email"];
		$find_user = User::where("email", $email)->first();

		// если пользователь найден
		if ($find_user !== null) {
			return response()->json([
				"success" => false,
				"message" => "Пользователь уже существует"
			]);
		}

		$password = $request->input("password");
		$hash_password = Hash::make($password);
		
		$new_user = User::create([
			"first_name" => $data["first_name"],
			"last_name" => $data["last_name"],
			"patronymic" => $data["patronymic"],
			"email" => $data["email"],
			"password" => $hash_password
		]);

		Passport::create([
			"series" => $data["passport_series"],
			"num" => $data["passport_id"],
			"user_id" => $new_user["id"]
		]);

		return response()->json([
			"success" => true,
			"message" => "Успешная регистрация. Ваш пароль: $password"
		]);
	}

	public function get_all() {
		$users = User::all();
	}

	public function get_by_id() {
		// $find_user = User::where(id)->get();
	}

	public function update() {
		// $find_user = User::find();
		// $find_user->update(["first_name" => "new name"]);
	}

	public function delete() {
		// $find_user = User::withTrashed()->find(id);
		// $find_user->restore();
	}
}
