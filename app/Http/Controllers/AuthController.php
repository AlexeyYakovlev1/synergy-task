<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Passport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use ReallySimpleJWT\Token;

class AuthController extends Controller
{
    public function login(Request $request)
	{
		$data = $request->validate([
			"email" => "required|string|email",
			"password" => "required|min:20|max:20"
		], [
			"email.required" => "Почта является обязательным для заполнения",
			"email.string" => "Почта должна быть строкой",
			"email.email" => "Почта введена неверно",
			"password.required" => "Пароль является обязательным для заполнения",
			"password.min" => "Пароль неверен",
			"password.max" => "Пароль неверен"
		]);
		
		$find_user = User::where("email", $data["email"])->first();

		// Проверка на почту
		if (!$find_user) {
			return response(
				[
					"success" => false,
					"message" => "Пользователя с такой почтой не существует"
				],
				400
			)
			->header("Content-Type", "application/json");
		}

		$check_password = Hash::check($data["password"], $find_user->password);

		// Проверка пароля
		if (!$check_password) {
			return response(
				[
					"success" => false,
					"message" => "Данные неверны"
				],
				400
			)
			->header("Content-Type", "application/json");
		}

		// Создание токена
		$payload = [
			"id" => $find_user->id,
			"exp" => time() + 10,
    		"iss" => "localhost"
		];
		$secret = env("JWT_KEY");
		
		$token = Token::customPayload($payload, $secret);

		return response(
			[
				"success" => true,
				"message" => "Выполнен вход",
				"token" => $token,
				"user_id" => $find_user->id
			],
			200
		)
		->header("Content-Type", "application/json");
	}

	public function registration(Request $request)
	{
		$data = $request->validate([
			"first_name" => "required|min:2|max:25",
			"last_name" => "required|min:2|max:30",
			"patronymic" => "required|min:2|max:50",
			"email" => "required|string|email",
			"password" => "required|min:20|max:20",
			"passport_series" => "required|min:4|max:4",
			"passport_id" => "required|min:6|max:6"
		], [
			"first_name.required" => "Имя является обязательным для заполнения",
			"first_name.min" => "Имя должно иметь минимум 2 символа",
			"first_name.max" => "Максимальная длина имени - 25 символов",
			"last_name.required" => "Фамилия является обязательным для заполнения",
			"last_name.min" => "Фамилия должна иметь минимум 2 символа",
			"last_name.max" => "Максимальная длина имени - 30 символов",
			"patronymic.required" => "Отчество является обязательным для заполнения",
			"patronymic.min" => "Отчество должно иметь минимум 2 символа",
			"patronymic.max" => "Максимальная длина отчества - 50 символов",
			"email.required" => "Почта является обязательным для заполнения",
			"email.string" => "Почта должна быть строкой",
			"email.email" => "Почта введена неверно",
			"password.required" => "Пароль является обязательным для заполнения",
			"password.min" => "Пароль должен содержать 20 символов",
			"password.max" => "Пароль должен содержать 20 символов",
			"passport_series.required" => "Серия паспорта является обязательным для заполнения",
			"passport_series.min" => "Серия паспорта должена содержать 4 цифры",
			"passport_series.max" => "Серия паспорта должена содержать 4 цифры",
			"passport_id.required" => "Номер паспорта является обязательным для заполнения",
			"passport_id.min" => "Номер паспорта должен содержать 6 цифр",
			"passport_id.max" => "Номер паспорта должен содержать 6 цифр"
		]);

		$find_user = User::where("email", $data["email"])->first();

		// Проверка на почту
		if ($find_user) {
			return response(
				[
					"success" => false,
					"message" => "Пользователь с такой почтой уже существует"
				],
				200
			)
			->header("Content-Type", "application/json");
		}

		// Проверка паспорта на номер
		$find_passport = Passport::where("num", $data["passport_id"])->first();

		if ($find_passport) {
			return response(
				[
					"success" => false,
					"message" => "Пользователь с таким паспортом уже существует"
				],
				400
			)
			->header("Content-Type", "application/json");
		}

		$hash_password = Hash::make($data["password"]);

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

		return response(
			[
				"success" => true,
				"message" => "Успешная регистрация",
				"password" => $data["password"]
			],
			201
		)
		->header("Content-Type", "application/json");
	}
}
