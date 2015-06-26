<?php namespace SSOLeica\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use SSOLeica\Core\Model\DetalleHorasHombre;
use SSOLeica\Core\Model\HorasHombre;
use SSOLeica\Core\Model\Month;
use SSOLeica\Core\Model\TrabajadorContrato;
use SSOLeica\Core\Repository\ContratoRepository;
use SSOLeica\Core\Repository\HorasHombreRepository;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HorasHombreController extends Controller {

    /**
     * @var OperacionRepository
     */
    private $operacionRepository;
    /**
     * @var ContratoRepository
     */
    private $contratoRepository;
    /**
     * @var HorasHombreRepository
     */
    private $horasHombreRepository;

    /**
     * @param OperacionRepository $operacionRepository
     * @param ContratoRepository $contratoRepository
     * @param HorasHombreRepository $horasHombreRepository
     */
    public function __construct(OperacionRepository $operacionRepository,
                                ContratoRepository $contratoRepository,
                                HorasHombreRepository $horasHombreRepository){
        $this->middleware('workspace');
        $this->operacionRepository = $operacionRepository;
        $this->contratoRepository = $contratoRepository;
        $this->horasHombreRepository = $horasHombreRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{


		dd('index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        $months = array('' => '[-- Seleccione --]') + Month::where('year','=','2015')->lists('nombre','id');
        $proyectos = array('' => '[-- Seleccione --]') + $this->operacionRepository->getOperaciones(Session::get('pais_id'))
                        ->lists('nombre_operacion','id');

        //dd($operaciones);
		return view('horasHombre.create')
                ->with('months',$months)
                ->with('proyectos',$proyectos);
	}

    public function  postCreate(){

        $trabajadores = Input::get('trabajador');
        $horas = Input::get('horas');
        $month_id = Input::get('month');
        $contrato_id = Input::get('contrato');

        $data = $this->horasHombreRepository->registrar($month_id,$contrato_id,$trabajadores,$horas);

        dd($data);
    }

    public function getContratos($id = 0)
    {
        $query = $this->contratoRepository->getListsContrato($id);
        return  Response::json($query);
    }

    public function getTrabajadorescontrato($contrato_id = 0){
        $trabajadores = TrabajadorContrato::where('contrato_id','=',$contrato_id)
                        ->where('is_activo','=',true)
                        ->get()->load('trabajador.cargo');

        //dd($trabajadores[0]->trabajador->cargo->name);

        return view('horasHombre.trabajadores')
            ->with('trabajadores',$trabajadores);
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
	public function getEdit($id=0)
	{
		$horasHombre = HorasHombre::where('id','=',$id)->get()
                        ->load('contrato.operacion')
                        ->load('mes')
                        ->first();

        $query = "select case when dhh.id is null then 0 else dhh.id end as id,";
        $query .= "case when hh.id is null then 0 else hh.id end as horas_hombre_id,";
        $query .= "t.id as trabajador_id,";
        $query .= "(t.app_paterno || t.app_materno || ', ' || t.nombre) as trabajador,c.name as cargo,";
        $query .= "case when dhh.horas is null then 0 else dhh.horas end as horas ";
        $query .= "from trabajador_contrato tc ";
        $query .= "left join trabajador t on tc.trabajador_id = t.id ";
        $query .= "left join enum_tables c on t.cargo_id = c.id ";
        $query .= "left join horas_hombre hh on tc.contrato_id = hh.contrato_id ";
        $query .= "left join detalle_horas_hombre dhh on hh.id = dhh.horas_hombre_id and t.id = dhh.trabajador_id ";
        $query .= "where hh.id = :id and tc.is_activo = true";

        $trabajadores = DB::select(DB::Raw($query),array('id' => $id));

       // dd($horasHombre);

        return view('horasHombre.edit')
                    ->with('horasHombre',$horasHombre)
                    ->with('trabajadores',$trabajadores);
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
