<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use ReallySimpleJWT\Token;

class RedirectIfTokenExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		if (!array_key_exists("token", $_COOKIE)) return $next($request);

		$current_token = $_COOKIE["token"];
		$secret = env("JWT_KEY");
		
		$validate_token = Token::validate($current_token, $secret);
		$payload_from_token = Token::getPayload($current_token);
		$user_id = $payload_from_token["id"];
		$find_user = User::where("id", $user_id)->first();

		// Если токен валидный и пользователь с таким идентификатором существует, то редиректим на страницу пользователя
		if ($validate_token && (bool) $find_user === true) return redirect("/user/".$user_id);

		return $next($request);
    }
}
