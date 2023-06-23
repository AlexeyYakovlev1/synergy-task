<?php

namespace App\Http\Middleware;

use App\Models\Passport;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DataIfTokenExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		// Если текущий пользователь не вошел, то редиректим назад
        if (!array_key_exists("token", $_COOKIE)) {
			return abort(404);
		}

		$current_token = $_COOKIE["token"];
		$secret = env("JWT_KEY");

		$validate_token = Token::validate($current_token, $secret);
    
		// Если токен невалиден
		if (!$validate_token) {
			return abort(404);
		}

		$payload_from_token = Token::getPayload($current_token);
		$user_id = $payload_from_token["id"];
		$find_user = User::where("id", $user_id)->first();

		if (!$find_user) {
			return abort(404);
		}

		$find_passport = Passport::where("user_id", $find_user->id)->first();

		if (!$find_passport) {
			return abort(404);
		}

		return new Response(view("pages.settings", [
			"user" => $find_user,
			"passport" => $find_passport
		]));
	}
}
