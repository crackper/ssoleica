<?php namespace SSOLeica\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Traits\Prorrogas;

class ProrrogaMiddleware {

	use Prorrogas;

    /**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $this->getCantProrrogasPendientes(Session::get('pais_id'));

		return $next($request);
	}

}
