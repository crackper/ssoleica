<?php namespace SSOLeica\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WorkSpace {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if (!Session::has('pais_id') &&  !Session::has('pais_name'))
        {
            return new RedirectResponse(url('/pais'));

        }

		return $next($request);
	}

}
