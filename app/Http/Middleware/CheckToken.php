<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Utils\AuthToken;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		$authorization_header = $request->header("Authorization") ?? "";
		$token = str_replace("Bearer ", "", $authorization_header);
		$decode = AuthToken::decode($token);
		
		if ($decode) {
			$user_id = $decode["user_id"];
			$find_user = User::find($user_id);

			$request->merge(["isAuth" => (bool) $find_user]);
		}

        return $next($request);
    }
}
