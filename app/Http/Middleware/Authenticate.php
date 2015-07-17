<?php namespace SSOLeica\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->auth->guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('auth/login');
			}
		}

		return $next($request);
	}

    /**
     * Analiza si el usuario autentificado
     * tiene el(los) rol(es) solicitado(s) en la ruta
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function analiceWithRole($request, $next)
    {
        if($this->auth->user()->hasRole($this->roles))
        {
            if($this->needsPerms)
            {
                return $this->analiceWithPerms($request, $next);
            }

            return $next($request);
        }
        else
        {
            Flash::warning('No Tiene permisos suficientes para acceder a este recurso.');

            return redirect()->back(302);
        }
    }

    /**
     * Analiza si el usuario autentificado
     * tiene los permisos solicitados en la ruta
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function analiceWithPerms($request, $next)
    {
        if($this->auth->user()->can($this->permissions))
        {
            return $next($request);
        }
        else
        {
            Flash::warning('No Tiene acceso a este recurso.');

            return redirect()->back(302);
        }
    }

}
