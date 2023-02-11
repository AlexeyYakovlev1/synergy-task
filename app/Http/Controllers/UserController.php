<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use ReallySimpleJWT\Token;

class UserController extends Controller
{
	protected $table = "users";

	// Страница регистрации
	public function registration_get() {
		return view("auth.registration", [
			"title" => "Страница регистрации"
		]);
	}

	// Страница входа
	public function login_get() {
		return view("auth.login", [
			"title" => "Страница входа"
		]);
	}

	// Страница профиля
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

	// Страница настроек
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

	// Изменение данных
	public function profile_change(Request $request, $id) {
		if (!$request->isAuth) {
			return response()->json([
				"success" => false,
				"message" => "Доступ закрыт"
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
			"description.min" => "Описание должно иметь минимум 5 символов",
			"description.max" => "Максимальная длина описания - 500 символов",
			"city.min" => "Название города должно иметь минимум 2 символа",
			"city.max" => "Максимальная длина названия города - 20 символов",
			"age.numeric" => "Возраст должен быть числом",
			"age.min" => "Вам должно быть минимум 14 лет",
			"age.max" => "Вам может быть максимум 150 лет"
		]);

		// Установка дефолтных значений
		if ($data_for_user["description"] === null) $data_for_user["description"] = "Нет описания";
		if ($data_for_user["city"] === null) $data_for_user["city"] = "Нет города";
		if ($data_for_user["age"] === null) $data_for_user["age"] = "Нет возраста";

		$data_for_passport = $request->validate([
			"passport_series" => "required|min:4|max:4",
			"passport_id" => "required|min:6|max:6",
		], [
			"passport_series.required" => "Серия паспорта является обязательным для заполнения",
			"passport_series.min" => "Серия паспорта должена содержать 4 цифры",
			"passport_series.max" => "Серия паспорта должена содержать 4 цифры",
			"passport_id.required" => "Номер паспорта является обязательным для заполнения",
			"passport_id.min" => "Номер паспорта должен содержать 6 цифр",
			"passport_id.max" => "Номер паспорта должен содержать 6 цифр"
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

	// Проверка пользователя на вход
	public function auth_check(Request $request, $id) {
		if (!$request->isAuth) {
			return response()->json([
				"success" => false
			]);
		}

		$find_user = User::where("id", $id)->first();
		
		if ($find_user === null) {
			return response()->json([
				"success" => false
			]);
		}

		$jwt_key = env("JWT_KEY");
		$user_id = $find_user->id;
		$expiration = time() * 3600; // 1 hour
		$issuer = env("HOST");

		$token = Token::create($user_id, $jwt_key, $expiration, $issuer);

		return response()->json([
			"success" => true,
			"user" => $find_user,
			"token" => $token
		]);
	}

	// Логин
	public function login(Request $request) {
		$data = $request->validate([
			"email" => "required|string|email",
			"password" => "required|min:20|max:20"
		], [
			"email.required" => "Почта является обязательным для заполнения",
			"email.string" => "Почта должна быть строкой",
			"email.email" => "Почта введена неверно",
			"password.required" => "Пароль является обязательным для заполнения",
			"password.min" => "Пароль должен содержать 20 символов",
			"password.max" => "Пароль должен содержать 20 символов"
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
		if (!$decode_password) {
			return response()->json([
				"success" => false,
				"message" => "Данные неверны"
			]);
		}

		$jwt_key = env("JWT_KEY");
		$user_id = $find_user->id;
		$expiration = time() * 3600; // 1 hour
		$issuer = env("HOST");

		$token = Token::create($user_id, $jwt_key, $expiration, $issuer);

		return response()->json([
			"success" => true,
			"message" => "Успешный вход",
			"user" => $find_user,
			"token" => $token,
			"passwordUsr" => $data["password"]
		])->header("Content-Type", "application/json");
	}

	// Создание
	public function create(Request $request) {
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
