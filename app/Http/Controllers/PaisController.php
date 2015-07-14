<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Helpers\Helpers;
use SSOLeica\Core\Repository\EnumTablesRepository as EnumTables;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\Helper;

class PaisController extends Controller {
    /**
     * @var EnumTables
     */
    private $enum_tables;


    /**
     * @param EnumTables $enum_tables
     */
    public function __construct(EnumTables $enum_tables)
    {

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

        $pais = $this->enum_tables->find($pais_id);
        $data = json_decode($pais->data);


        Session::put('pais_id', $pais_id);
        Session::put('pais_name', $pais->name);
        Session::put('timezone', $data[0]->timezone);
        Session::put('diff_timezone', $data[0]->diff);


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
