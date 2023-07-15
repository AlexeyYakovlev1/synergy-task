<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!array_key_exists("token", $_COOKIE))
		{
			$request->merge(["isAuth" => false]);
			
			return $next($request);
		}

		$current_token = $_COOKIE["token"];
		$secret = env("JWT_KEY");
		
		$validate_token = Token::validate($current_token, $secret);

		if (!$validate_token)
		{
			$request->merge(["isAuth" => false]);
			
			return $next($request);
		}
		
		$payload_from_token = Token::getPayload($current_token);
		$find_user = User::where("id", $payload_from_token["id"])->first();

		$request->merge([
			"isAuth" => (bool) $find_user,
			"user" => $find_user
		]);
			
		return $next($request);
    }
}
