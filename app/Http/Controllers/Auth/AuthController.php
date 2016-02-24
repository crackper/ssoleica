<?php namespace SSOLeica\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Repository\EnumTablesRepository;
use SSOLeica\Core\Traits\Alertas;
//use SSOLeica\Core\Traits\Prorrogas;
use SSOLeica\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, \SSOLeica\Core\Traits\Prorrogas, \SSOLeica\Core\Traits\Alertas;
    /**
     * @var EnumTablesRepository
     */
    private $enumTablesRepository;

    /**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar,EnumTablesRepository $enumTablesRepository)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
        $this->enumTablesRepository = $enumTablesRepository;

		$this->middleware('guest', ['except' => 'getLogout']);

    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['active'] = 1;

        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
            if(Auth::user()->pais_id)
            {
                $pais_id = Auth::user()->pais_id;

                //alertas
                $this->getAlertas($pais_id);

                //Cantidad Prorrogas por aprobar
                $this->getCantProrrogasPendientes($pais_id);
            }
            else
            {
                Session::forget('pais_id');
                Session::forget('pais_name');
                Session::forget('timezone');
            }


            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

}
