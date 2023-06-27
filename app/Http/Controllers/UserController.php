<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(Request $request, string $id) {
		if (!$request->isAuth) {
			return response(
				[
					"success" => false,
					"message" => "Доступ закрыт"
				],
				400
			)
			->header("Content-Type", "application/json");
		}

		$data_for_user = $request->validate([
			"first_name" => "required|min:2|max:25",
			"last_name" => "required|min:2|max:30",
			"patronymic" => "required|min:2|max:50",
			"email" => "required|string|email",
			"description" => "nullable|min:5|max:500",
			"city" => "nullable|min:2|max:20",
			"age" => "nullable|numeric|min:14|max:150",
			"avatar" => "max:1024|mimes:png,jpg,jpeg,svg"
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
			"age.max" => "Вам может быть максимум 150 лет",
			"avatar.max" => "Файл аватара не может весить больше 1мб",
			"avatar.mimes" => "Файл аватара может иметь следующие расширения: png, jpg, jpeg, svg"
		]);

		// Установка дефолтных значений
		if ($data_for_user["description"] === null) $data_for_user["description"] = "Нет описания";
		if ($data_for_user["city"] === null) $data_for_user["city"] = "Нет города";
		if ($data_for_user["age"] === null) $data_for_user["age"] = "Нет возраста";
		if ($data_for_user["avatar"] === null) $data_for_user["avatar"] = "avatar-default.png";

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
				return response(
					[
						"success" => false,
						"message" => "Пользователь с такой почтой уже существует"
					],
					400
				)
				->header("Content-Type", "application/json");
			}
		}

		$new_avatar = $request->file("avatar");

		if ($request->hasFile("avatar") && $new_avatar->isValid()) {
			$old_avatar = $find_user->avatar;
			$ext = $new_avatar->getClientOriginalExtension();
			$file_name = $find_user->id . '-' . date('Y-m-d-H-i-s') . "." . $ext;

			if ($old_avatar !== "avatar-default.png") {
				Storage::delete("public/avatars/" . $old_avatar);
			}

			$new_avatar->storeAs("public/avatars", $file_name);
			$data_for_user["avatar"] = $file_name;
		}

		// проверка на номер паспорта
		if ($find_passport["series"] !== $data_for_passport["passport_series"]) {
			$find_passport_by_series = Passport::where("series", $data_for_passport["passport_series"])->first();

			if ($find_passport_by_series !== null) {
				return response(
					[
						"success" => false,
						"message" => "Пользователь с таким паспортом уже существует"
					],
					400
				)
				->header("Content-Type", "application/json");
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

		return response(
			[
				"success" => true,
				"message" => "Пользователь обновлен"
			],
			200
		)
		->header("Content-Type", "application/json");
	}
}
