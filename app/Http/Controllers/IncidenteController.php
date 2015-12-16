<?php namespace SSOLeica\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Model\CargosTrabajador;
use SSOLeica\Core\Model\Trabajador;
use SSOLeica\Core\Repository\ContratoRepository;
use SSOLeica\Core\Repository\EnumTablesRepository;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Core\Repository\TrabajadorRepository;
use SSOLeica\Http\Requests;
use Illuminate\Support\Facades\Response;
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;

class IncidenteController extends Controller {


    private $pais;
    private $timezone;
    /**
     * @var OperacionRepository
     */
    private $operacionRepository;
    /**
     * @var ContratoRepository
     */
    private $contratoRepository;
    /**
     * @var TrabajadorRepository
     */
    private $trabajadorRepository;
    /**
     * @var EnumTablesRepository
     */
    private $enumTablesRepository;

    /**
     * @param OperacionRepository $operacionRepository
     * @param ContratoRepository $contratoRepository
     * @param TrabajadorRepository $trabajadorRepository
     * @param EnumTablesRepository $enumTablesRepository
     */
    public function __construct(OperacionRepository $operacionRepository,
                                ContratoRepository $contratoRepository,
                                TrabajadorRepository $trabajadorRepository,
                                EnumTablesRepository $enumTablesRepository)
    {
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->pais = Session::get('pais_id');
        $this->timezone = Session::get('timezone');
        $this->operacionRepository = $operacionRepository;
        $this->contratoRepository = $contratoRepository;
        $this->trabajadorRepository = $trabajadorRepository;
        $this->enumTablesRepository = $enumTablesRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return view("home");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        $proyectos = array('' => '[-- Seleccione --]') + $this->operacionRepository->getOperaciones($this->pais)
                ->lists('nombre_operacion','id');

        $tipo_incidiente =  array('' => '[-- Seleccione --]') + $this->enumTablesRepository->getEnumTables('Incidente')
                        ->lists('name','id');

        $tipo_informe =  array('' => '[-- Seleccione --]') + $this->enumTablesRepository->getEnumTables('Informe')
                ->lists('name','id');


        return view("incidente.create")
                    ->with('proyectos',$proyectos)
                    ->with('tipo_incidente',$tipo_incidiente)
                    ->with('tipo_informe',$tipo_informe)
                    ->with('trabajadores',$this->getTrabajadores());
	}

    public function getContratos($id = 0)
    {
        $query = $this->contratoRepository->getListsContrato($id);
        return  Response::json($query);
    }

    /**
     * @return array
     */
    public function getTrabajadores()
    {
        $query = $this->trabajadorRepository->getTrabajadoresList($this->pais);

        $trabajadores = array();

        $trabajadores[''] = '[-– Seleccione –-]';

        foreach ($query as $row) {
            $trabajadores[$row->id] = $row->nombre . " " . $row->app_paterno . " " . $row->app_materno;
        }
        return $trabajadores;
    }

    public function getTrabajador($key = '')
    {
        $query = Trabajador::where(DB::raw("upper(nombre) like '%'|| upper('".$key."') || '%' or upper(app_paterno) like '%'|| upper('".$key."') || '%'"))
            ->where("pais_id",$this->pais)
            ->orderBy('nombre', 'asc')
            ->skip(0)->take(10)->get();

        $data = array();
        foreach($query as $trabajador)
        {
            $data[] = array('id' => $trabajador->id, 'name' =>  $trabajador->nombre .' '. $trabajador->app_paterno, 'email' => $trabajador->email );
        }

        return Response::json($data);
    }

    public function getTrabajadorcargo($trabajador_id = 0,$fecha = '')
    {
        $query = CargosTrabajador::where('trabajador_id',$trabajador_id)
                ->where('inicio','<=',$fecha)->get()
                ->load('trabajador')
                ->load('cargo')
                ->first();

        if(!is_null($query))
        {
            $data['status']         = true;
            $data['cargo_id']       = $query->id;
            $data['trabajador_id']  = $query->trabajador->id;
            $data['trabajador']     = $query->trabajador->FullName1;
            $data['dni']            = $query->trabajador->dni;
            $data['cargo']          = $query->cargo->name;
            $data['fecha_ingreso']  = Carbon::parse($query->inicio)->format('d/m/Y');
            $data['fecha_cargo']    = Carbon::parse($query->inicio)->format('d/m/Y');
        }
        else
        {
            $query = CargosTrabajador::where('trabajador_id',$trabajador_id)->get()
                ->load('trabajador')
                ->load('cargo')
                ->first();

            $data['status']         = false;
            $data['cargo_id']       = $query->id;
            $data['trabajador_id']  = $query->trabajador->id;
            $data['trabajador']     = $query->trabajador->FullName1;
            $data['dni']            = $query->trabajador->dni;
            $data['cargo']          = $query->cargo->name;
            $data['fecha_ingreso']  = Carbon::parse($query->inicio)->format('d/m/Y');
            $data['fecha_cargo']    = Carbon::parse($query->inicio)->format('d/m/Y');
        }

        Return Response::json($data);
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
