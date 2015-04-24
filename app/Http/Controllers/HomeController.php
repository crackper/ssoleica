<?php namespace SSOLeica\Http\Controllers;

use SSOLeica\Core\Model\EnumTables;
use SSOLeica\Core\Model\Trabajador;
use SSOLeica\Core\Model\TrabajadorOperacion;
use SSOLeica\Core\Repository\TrabajadorRepository;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

    /**
     * @var TrabajadorRepository
     */
    private $trabajadorRepository;

    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(TrabajadorRepository $trabajadorRepository)
	{
        $this->trabajadorRepository = $trabajadorRepository;
    }

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
       // $trabajador = Trabajador::find(1)->load('profesion','operaciones.operacion.examenes_medicos.examen');

        //$enum = EnumTables::find(14)->load('trabajadores.profesion');
        //$operacion = TrabajadorOperacion::find(1);

        //dd($trabajador);

		//return view('home');

        //return \Response::json($this->trabajadorRepository->find('1')->load('profesion'));

        dd($this->trabajadorRepository->getModel()->where('apellidos', 'like', '%u%')->get()->load('profesion'));

        //
        //dd($this->trabajadorRepository->find('1')->load('profesion'));
	}

}
