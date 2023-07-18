<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create(Request $request)
	{
		try {
			if (!$request->isAuth)
			{
				return response(
					[
						"success" => false,
						"message" => "Доступ закрыт"
					],
					400
				)
				->header("Content-Type", "application/json");
			}

			$data = $request->validate([
				"content" => "required|min:30|max:1000",
				"cover" => "max:10240|mimes:png,jpg,jpeg,svg,gif"
			], [
				"content.required" => "Поле с контентом должно быть заполнено",
				"content.min" => "30 символов минимальная длина контента",
				"content.max" => "1000 символов максимальная длина контента",
				"cover.max" => "Файл обложки не может весить больше 10мб",
				"cover.mimes" => "Файл обложки может иметь следующие расширения: png, jpg, jpeg, svg, gif"
			]);

			$cover = $request->file("cover");

			/**
			 * TODO:
			 * Утилита, которая проверяет наличие и валидность приходящего файла
			 */
			if ($request->hasFile("cover") && $cover->isValid())
			{
				$ext = $cover->getClientOriginalExtension();
				$file_name = $request->user->id . "-" . date("Y-m-d-H-i-s") . "." . $ext;

				$cover->storeAs("public/covers", $file_name);
				$data["cover"] = $file_name;
			}

			$data["owner_id"] = $request->user->id;
			
			Post::create($data);

			return response(
				[
					"success" => true,
					"message" => "Пост создан"
				],
				201
			)
			->header("Content-Type", "application/json");
		} catch(Exception $e) {
			return response(
				[
					"success" => false,
					"message" => "Ошибка сервера",
					"error_message" => $e->getMessage()
				],
				500
			)
			->header("Content-Type", "application/json");
		}
	}

	public function update(Request $request, string $id)
	{
		try {
			if (!$request->isAuth)
			{
				return response(
					[
						"success" => false,
						"message" => "Доступ закрыт"
					],
					400
				)
				->header("Content-Type", "application/json");
			}

			$data = $request->validate([
				"content" => "required|min:30|max:1000",
				"cover" => "max:10240|mimes:png,jpg,jpeg,svg,gif"
			], [
				"content.min" => "30 символов минимальная длина контента",
				"content.max" => "1000 символов максимальная длина контента",
				"cover.max" => "Файл обложки не может весить больше 10мб",
				"cover.mimes" => "Файл обложки может иметь следующие расширения: png, jpg, jpeg, svg, gif"
			]);

			$find_post = Post::where("id", $id)->first();

			if (!$find_post)
			{
				return response(
					[
						"success" => false,
						"message" => "Пост по идентификатору $id не существует"
					],
					400
				)
				->header("Content-Type", "application/json");
			}

			$new_data = [];
			$new_cover = $request->cover;

			if ($request->hasFile("cover") && $new_cover->isValid())
			{
				$old_cover = $find_post->cover;
				$ext = $new_cover->getClientOriginalExtension();
				$file_name = $find_post->id . "-" . date("Y-m-d-H-i-s") . "." . $ext;

				// Удаляем старую обложку
				Storage::delete("public/covers/" . $old_cover);
				
				// Сохраняем новую обложку
				$new_cover->storeAs("public/covers", $file_name);
				$new_data["cover"] = $file_name;
			}

			$new_data["content"] = $data["content"] ? $data["content"] : $find_post->content;

			$find_post->fill($new_data);
			$find_post->save();

			return response(
				[
					"success" => true,
					"message" => "Пост обновлен"
				],
				200
			)
			->header("Content-Type", "application/json");
		} catch(Exception $e) {
			return response(
				[
					"success" => false,
					"message" => "Ошибка сервера",
					"error_message" => $e->getMessage()
				],
				500
			)
			->header("Content-Type", "application/json");
		}
	}

	public function remove(Request $request, string $id)
	{
		try {
			if (!$request->isAuth)
			{
				return response(
					[
						"success" => false,
						"message" => "Доступ закрыт"
					],
					400
				)
				->header("Content-Type", "application/json");
			}

			$find_post = Post::where("id", $id)->first();

			if (!$find_post)
			{
				return response(
					[
						"success" => false,
						"message" => "Пост по идентификатору $id не существует"
					],
					400
				)
				->header("Content-Type", "application/json");
			}

			$find_user = User::where("id", $request->user->id)->first();

			// Если удаление производит не владелец поста
			if ((string) $find_user->id !== (string) $find_post->owner_id)
			{
				return response(
					[
						"success" => false,
						"message" => "Доступ закрыт"
					],
					400
				)
				->header("Content-Type", "application/json");
			}

			// Удаляем обложку, если она существует в covers
			$cover = $find_post->cover;
			$cover_exists = Storage::disk("public")->exists("covers/$cover");

			if ($cover_exists) Storage::delete("public/covers/" . $cover);

			$find_post->delete();

			return response(
				[
					"success" => true,
					"message" => "Пост удален"
				],
				200
			)
			->header("Content-Type", "application/json");
		} catch(Exception $e) {
			return response(
				[
					"success" => false,
					"message" => "Ошибка сервера",
					"error_message" => $e->getMessage()
				],
				500
			)
			->header("Content-Type", "application/json");
		}
	}

	public function get_one(Request $request, string $id)
	{
		$find_post = Post::where("id", $id)->first();

		if (!$find_post) return abort(404);

		return response(
			[
				"success" => true,
				"post" => $find_post
			],
			200
		)
		->header("Content-Type", "application/json");
	}

	public function view_create(Request $request)
	{
		if (!$request->isAuth) return abort(404);

		return view("pages.post.create", [
			"title" => "Создать пост",
			"notMyProfile" => false,
			"user" => $request->user,
			"post" => null
		]);
	}

	public function view_edit(Request $request, string $id)
	{
		if (!$request->isAuth) return abort(404);

		$find_post = Post::where("id", $id)->first();

		if (!$find_post) return abort(404);

		return view("pages.post.create", [
			"title" => "Изменить пост",
			"notMyProfile" => false,
			"user" => $request->user,
			"post" => $find_post
		]);
	}

	public function get_by_user_id(Request $request, string $user_id)
	{
		try {
			$find_posts = Post::where("owner_id", $user_id)->get();
			$find_user = User::where("id", $user_id)->first();

			if (!$find_user) return abort(404);

			return response(
				[
					"success" => true,
					"posts" => $find_posts,
					"owner" => $find_user
				],
				200
			)
				->header("Content-Type", "application/json");
		} catch(Exception $e) {
				return response(
				[
					"success" => false,
					"message" => "Ошибка сервера",
					"error_message" => $e->getMessage()
				],
				500
			)
			->header("Content-Type", "application/json");
		}
	}

	public function get_all(Request $request)
	{
		$all_posts = Post::all();

		return response(
			[
				"success" => true,
				"posts" => $all_posts
			],
			200
		)
			->header("Content-Type", "application/json");
	}
}
