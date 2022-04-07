<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsAdmin
{
	/**
	 * Handle an incoming request.
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ( auth()->user()->role != \App\Models\User::ROLE_ADMIN )
		{
			return redirect('/');
		}

		return $next($request);
	}
}
