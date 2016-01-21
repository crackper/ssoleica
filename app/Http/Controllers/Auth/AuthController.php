<?php namespace SSOLeica\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Repository\EnumTablesRepository;
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

	use AuthenticatesAndRegistersUsers;
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

                $pais = $this->enumTablesRepository->find($pais_id);
                $data = json_decode($pais->data);

                Session::put('pais_id', $pais_id);
                Session::put('pais_name', $pais->name);
                Session::put('timezone', $data->timezone);

                $total = 0;
                $total_nxm = 0;

                //Cantidad Mes Actual FotoChecks
                $queryF = "select count(*) cant ";
                $queryF .= "from trabajador_contrato tc ";
                $queryF .= "inner join trabajador t on tc.trabajador_id = t.id ";
                $queryF .= "where (tc.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month')) ";
                $queryF .= "and t.pais_id = :id";

                $cant_f = DB::select(DB::Raw($queryF),array('id' => $pais_id));

                Session::put('cant_f', $cant_f[0]->cant);
                $total+= $cant_f[0]->cant;
                /*++++++++++++++++++++++++++++++++++++++++++++++++*/

                //Cantidad Proximos Mes FotoChecks
                $queryF_nxm = "select count(*) cant ";
                $queryF_nxm .= "from trabajador_contrato tc ";
                $queryF_nxm .= "inner join trabajador t on tc.trabajador_id = t.id ";
                $queryF_nxm .= "where (tc.fecha_vencimiento  between (DATE_TRUNC('month', nextmes()) at time zone 'utc') and  ((DATE_TRUNC('month', nextmes())  at time zone 'utc') + '1 month')) ";
                $queryF_nxm .= "and t.pais_id = :id";

                $cant_f_nxm = DB::select(DB::Raw($queryF_nxm),array('id' => $pais_id));

                Session::put('cant_f_nxm', $cant_f_nxm[0]->cant);
                $total_nxm+= $cant_f_nxm[0]->cant;
                /*++++++++++++++++++++++++++++++++++++++++++++++++*/

                //Cantidad Mes Actual Exam. Medicos
                $queryE = "select count(*) as cant ";
                $queryE .= "from trabajador_vencimiento tv ";
                $queryE .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
                $queryE .= "inner join trabajador t on tv.trabajador_id = t.id ";
                $queryE .= "where tv.caduca = true  and v.type = 'ExamenMedico' and t.pais_id = :id ";
                $queryE .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month'))";

                $cant_e = DB::select(DB::Raw($queryE),array('id' => $pais_id));

                Session::put('cant_e', $cant_e[0]->cant);
                $total+= $cant_e[0]->cant;
                /*++++++++++++++++++++++++++++++++++++++++++++++++*/

                //Cantidad Proximo mes Exam. Medicos
                $queryE_nxm = "select count(*) as cant ";
                $queryE_nxm .= "from trabajador_vencimiento tv ";
                $queryE_nxm .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
                $queryE_nxm .= "inner join trabajador t on tv.trabajador_id = t.id ";
                $queryE_nxm .= "where tv.caduca = true  and v.type = 'ExamenMedico' and t.pais_id = :id ";
                $queryE_nxm .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', nextmes()) at time zone 'utc') and  ((DATE_TRUNC('month', nextmes())  at time zone 'utc') + '1 month'))";

                $cant_e_nxm = DB::select(DB::Raw($queryE_nxm),array('id' => $pais_id));

                Session::put('cant_e_nxm', $cant_e[0]->cant);
                $total_nxm+= $cant_e_nxm[0]->cant;
                /*++++++++++++++++++++++++++++++++++++++++++++++++*/

                //Cantidad Mes Actual Documentos

                $queryD = "select count(*) as cant ";
                $queryD .= "from trabajador_vencimiento tv ";
                $queryD .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
                $queryD .= "inner join trabajador t on tv.trabajador_id = t.id ";
                $queryD .= "where tv.caduca = true  and v.type = 'Documento' and t.pais_id = :id ";
                $queryD .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month'))";

                $cant_d = DB::select(DB::Raw($queryD),array('id' => $pais_id));

                Session::put('cant_d', $cant_d[0]->cant);
                $total+= $cant_d[0]->cant;
                /*++++++++++++++++++++++++++++++++++++++++++++++++*/

                //Cantidad Proximo mes Documentos

                $queryD_nxm = "select count(*) as cant ";
                $queryD_nxm .= "from trabajador_vencimiento tv ";
                $queryD_nxm .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
                $queryD_nxm .= "inner join trabajador t on tv.trabajador_id = t.id ";
                $queryD_nxm .= "where tv.caduca = true  and v.type = 'Documento' and t.pais_id = :id ";
                $queryD_nxm .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', nextmes()) at time zone 'utc') and  ((DATE_TRUNC('month', nextmes())  at time zone 'utc') + '1 month'))";

                $cant_d_nxm = DB::select(DB::Raw($queryD_nxm),array('id' => $pais_id));

                Session::put('cant_d_nxm', $cant_d_nxm[0]->cant);
                $total_nxm+= $cant_d_nxm[0]->cant;
                /*++++++++++++++++++++++++++++++++++++++++++++++++*/

                Session::put('total_n', $total + $total_nxm);
            }
            else
            {
                Session::forget('pais_id');
                Session::forget('pais_name');
                Session::forget('timezone');
            }

           // $updated_by = json_encode(array('id' => Auth::user()->id,'name'=>Auth::user()->name,'email'=>Auth::user()->email,'trabjador_id'=>Auth::user()->trabajador_id));

           // Session::put('updated_by',$updated_by);

            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

}
