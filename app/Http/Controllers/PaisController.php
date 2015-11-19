<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $pais = $this->enum_tables->find($pais_id);
        $data = json_decode($pais->data);


        Session::put('pais_id', $pais_id);
        Session::put('pais_name', $pais->name);
        Session::put('timezone', $data->timezone);

        $total = 0;

        //Cantidad FotoChecks
        $queryF = "select count(*) cant ";
        $queryF .= "from trabajador_contrato tc ";
        $queryF .= "inner join trabajador t on tc.trabajador_id = t.id ";
        $queryF .= "where (tc.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month')) ";
        $queryF .= "and t.pais_id = :id";

        $cant_f = DB::select(DB::Raw($queryF),array('id' => $pais_id));

        Session::put('cant_f', $cant_f[0]->cant);
        $total+= $cant_f[0]->cant;

        //Cantidad Exam. Medicos
        $queryE = "select count(*) as cant ";
        $queryE .= "from trabajador_vencimiento tv ";
        $queryE .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
        $queryE .= "inner join trabajador t on tv.trabajador_id = t.id ";
        $queryE .= "where tv.caduca = true  and v.type = 'ExamenMedico' and t.pais_id = :id ";
        $queryE .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month'))";

        $cant_e = DB::select(DB::Raw($queryE),array('id' => $pais_id));

        Session::put('cant_e', $cant_e[0]->cant);
        $total+= $cant_e[0]->cant;

        //Cantidad Documentos

        $queryD = "select count(*) as cant ";
        $queryD .= "from trabajador_vencimiento tv ";
        $queryD .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
        $queryD .= "inner join trabajador t on tv.trabajador_id = t.id ";
        $queryD .= "where tv.caduca = true  and v.type = 'Documento' and t.pais_id = :id ";
        $queryD .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month'))";

        $cant_d = DB::select(DB::Raw($queryD),array('id' => $pais_id));

        Session::put('cant_d', $cant_d[0]->cant);
        $total+= $cant_d[0]->cant;

        Session::put('total_n', $total);

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
