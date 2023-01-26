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

		if ($find_user === null) {
			return redirect("/");
		}

		return view("profile", [
			"title" => "Страница профиля",
			"user" => $find_user
		]);
	}

	public function settings_get($id) {
		$find_user = User::where("id", $id)->first();

		if ($find_user === null) {
			return redirect("/");
		}

		$find_passport = Passport::where("user_id", $id)->first();

		return view("settings", [
			"title" => "Страница настроек",
			"user" => $find_user,
			"passport" => $find_passport
		]);
	}

	public function profile_change(Request $request, $id) {
		$current_user_id = $request->query("current_user_id");
		
		if (!$current_user_id || $id !== $current_user_id) {
			return response()->json([
				"success" => false,
				"message" => "Недоступно"
			]);
		}

		$data_for_user = $request->validate([
			"first_name" => "required|min:2|max:25",
			"last_name" => "required|min:2|max:30",
			"patronymic" => "required|min:2|max:50",
			"email" => "required|string|email",
			"description" => "nullable|min:5|max:500",
			"city" => "nullable|min:2|max:20",
			"age" => "nullable|numeric|min:14|max:150"
		]);

		$data_for_passport = $request->validate([
			"passport_series" => "required|min:4|max:4",
			"passport_id" => "required|min:6|max:6",
		]);

		$find_user = User::where("id", $id)->first();
		$find_passport = Passport::where("user_id", $id)->first();

		// проверка на почту
		if ($find_user["email"] !== $data_for_user["email"]) {
			$find_user_by_email = User::where("email", $data_for_user["email"])->first();
			
			if ($find_user_by_email !== null) {
				return response()->json([
					"success" => false,
					"message" => "Пользователь с такой почтой уже существует"
				]);
			}
		}

		// проверка на номер паспорта
		if ($find_passport["series"] !== $data_for_passport["passport_series"]) {
			$find_passport_by_series = Passport::where("series", $data_for_passport["passport_series"])->first();

			if ($find_passport_by_series !== null) {
				return response()->json([
					"success" => false,
					"message" => "Пользователь с таким паспортом уже существует"
				]);
			}
		}

		// заменяем ключи для таблицы паспорта
		$data_for_passport["series"] = $data_for_passport["passport_series"];
		$data_for_passport["num"] = $data_for_passport["passport_id"];
		unset($data_for_passport["passport_series"]);
		unset($data_for_passport["passport_id"]);

		// обновляем пользователя
		$find_user->fill($data_for_user);
		$find_user->save();

		// обновляем паспорт
		$find_passport->fill($data_for_passport);
		$find_passport->save();

		return response()->json([
			"success" => true,
			"message" => "Пользователь обновлен",
			"user" => $find_user,
			"passport" => $find_passport
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
			"user" => $find_user,
			"passwordUsr" => $data["password"]
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
}
