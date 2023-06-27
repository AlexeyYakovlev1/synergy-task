<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use Illuminate\Http\Response;

class GiveUserData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		$user_id_from_route = $request->route("id");

		// Если текущий пользователь не вошел
        if (!array_key_exists("token", $_COOKIE)) {
			$find_user = User::where("id", $user_id_from_route)->first();

			if (!$find_user) return abort(404);

			$title = "$find_user->first_name $find_user->last_name";

			return new Response(view("pages.user", [
				"notMyProfile" => true,
				"user" => $find_user,
				"title" => $title
			]));
		};

		$current_token = $_COOKIE["token"];
		$secret = env("JWT_KEY");

		$validate_token = Token::validate($current_token, $secret);

		// Если у текущего пользователя невалидный токен
		if (!$validate_token) {
			$find_user = User::where("id", $user_id_from_route)->first();

			if (!$find_user) return abort(404);

			$title = "$find_user->first_name $find_user->last_name";

			return new Response(view("pages.user", [
				"notMyProfile" => true,
				"user" => $find_user,
				"title" => $title
			]));
		}

		$payload_from_token = Token::getPayload($current_token);
		$current_user = User::where("id", $payload_from_token["id"])->first();

		if (
			$user_id_from_route !== (string) $payload_from_token["id"] &&
			(bool) $current_user === true
		) {
			$find_user = User::where("id", $user_id_from_route)->first();
			$title = "$find_user->first_name $find_user->last_name";

			return new Response(view("pages.user", [
				"notMyProfile" => true,
				"user" => $find_user,
				"title" => $title
			]));
		}

		if (!$current_user) return abort(404);

		$title = "$current_user->first_name $current_user->last_name";

		return new Response(view("pages.user", [
			"notMyProfile" => false,
			"user" => $current_user,
			"title" => $title
		]));
	}
}