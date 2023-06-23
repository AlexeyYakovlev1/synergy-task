<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

		// Если токен нормальный, то редиректим на главную страницу
		if ($validate_token) return redirect("/user/".$payload_from_token["id"]);

		return $next($request);
    }
}
