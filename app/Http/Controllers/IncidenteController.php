<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Support\Facades\Session;
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
		return view("incidente.create");
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
