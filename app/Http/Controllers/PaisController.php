<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Helpers\Helpers;
use SSOLeica\Core\Repository\EnumTablesRepository as EnumTables;
use SSOLeica\Core\Traits\Alertas;
use SSOLeica\Core\Traits\Prorrogas;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\Helper;

class PaisController extends Controller {

   use \SSOLeica\Core\Traits\Prorrogas, \SSOLeica\Core\Traits\Alertas;

    /**
     * @var EnumTables
     */
    private $enum_tables;


    /**
     * @param EnumTables $enum_tables
     */
    public function __construct(EnumTables $enum_tables)
    {
        $this->middleware('auth');
        $this->enum_tables = $enum_tables;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $data['paises'] = $this->enum_tables->getPaises()->lists('name','id');

		return view('pais.index',$data);
	}

    /**
     * se asigna el workspace en funcion al pais seleccionado
     */
    public function workspace()
    {
        $pais_id = Input::get('pais_id');

        //alertas
        $this->getAlertas($pais_id);

        //Cantidad Prorrogas por aprobar
        $this->getCantProrrogasPendientes($pais_id);

        return new RedirectResponse(url('/home'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
