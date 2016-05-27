<?php namespace SSOLeica\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use SSOLeica\Core\Helpers\Timezone;
use SSOLeica\Core\Model\CargosTrabajador;
use SSOLeica\Core\Model\IncidenteFotos;
use SSOLeica\Core\Model\IncidenteMedidasSeguridad;
use SSOLeica\Core\Model\Trabajador;
use SSOLeica\Core\Repository\ContratoRepository;
use SSOLeica\Core\Repository\EnumTablesRepository;
use SSOLeica\Core\Repository\IncidenteRepository;
use SSOLeica\Core\Repository\MedidasSeguridadRepository;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Core\Repository\TrabajadorRepository;
use SSOLeica\Http\Requests;
use Illuminate\Support\Facades\Response;
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Zofe\Rapyd\DataForm\Field\Date;

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
     * @var IncidenteRepository
     */
    private $incidenteRepository;
    /**
     * @var MedidasSeguridadRepository
     */
    private $medidasSeguridadRepository;

    /**
     * @param OperacionRepository $operacionRepository
     * @param ContratoRepository $contratoRepository
     * @param TrabajadorRepository $trabajadorRepository
     * @param EnumTablesRepository $enumTablesRepository
     * @param IncidenteRepository $incidenteRepository
     */
    public function __construct(OperacionRepository $operacionRepository,
                                ContratoRepository $contratoRepository,
                                TrabajadorRepository $trabajadorRepository,
                                EnumTablesRepository $enumTablesRepository,
                                IncidenteRepository $incidenteRepository,
                                MedidasSeguridadRepository $medidasSeguridadRepository)
    {
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->pais = Session::get('pais_id');
        $this->timezone = Session::get('timezone');
        $this->operacionRepository = $operacionRepository;
        $this->contratoRepository = $contratoRepository;
        $this->trabajadorRepository = $trabajadorRepository;
        $this->enumTablesRepository = $enumTablesRepository;
        $this->incidenteRepository = $incidenteRepository;
        $this->medidasSeguridadRepository = $medidasSeguridadRepository;
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

        $consecuencias = $this->enumTablesRepository->getConsecuencias()
                ->lists('name','id');

        $partes_afectadas = $this->enumTablesRepository->getPartesAfectadas();
            //->lists('name','id');

        $entidades = $this->enumTablesRepository->getEntidades()
            ->lists('name','id');

        $jornadas =  array('' => '[-- Seleccione --]') + $this->enumTablesRepository->getEnumTables('Jornada')
                ->lists('name','id');

        //dd($partes_afectadas);

        return view("incidente.create")
                    ->with('proyectos',$proyectos)
                    ->with('tipo_incidente',$tipo_incidiente)
                    ->with('tipo_informe',$tipo_informe)
                    ->with('consecuencias',$consecuencias)
                    ->with('partes_afectadas',$partes_afectadas)
                    ->with('entidades',$entidades)
                    ->with('jornadas',$jornadas)
                    ->with('trabajadores',$this->getTrabajadores());
	}

    public function postCreate(Request $request)
    {
        //General
        $data['pais_id'] = $this->pais;
        $data['contrato_id'] = Input::get('contrato_id');
        $data['tipo_informe_id'] = Input::get('tipo_informe');
        $data['tipo_incidente_id'] = Input::get('tipo_incidente');
        $data['fecha'] = Timezone::toUTC(Input::get('fecha'),$this->timezone);
        $data['lugar'] = Input::get('lugar');
        $data['punto'] = Input::get('punto');
        $data['equipos'] = Input::get('equipos');
        $data['parte'] = Input::get('parte');
        $data['sector'] = Input::get('sector');

        if(Input::get('responsables') != '')
            $data['responsable_id'] = Input::get('responsables');

       /*$trb = array();

        if($request->has('trbAfectado') && $request->has('trAfeCargo'))
        {
            for($i = 0; $i < count($request->get('trbAfectado')); $i++)
            {
                $trb[] = array('trabajador_id'=>$request->get('trbAfectado')[$i], 'cargo_id' => $request->get('trAfeCargo')[$i]);
            }

            $data['tr_afectados'] = json_encode($trb,JSON_NUMERIC_CHECK);
        }*/

        if($request->has('trbAfectado'))
            $data['tr_afectados'] = json_encode($request->get('trbAfectado'),JSON_NUMERIC_CHECK);

        /*$tr = array();

        if($request->has('trbInvolucrado') && $request->has('trInvolucrado'))
        {
            for($i = 0; $i < count($request->get('trbInvolucrado')); $i++)
            {
                $tr[] = array('trabajador_id'=>$request->get('trbInvolucrado')[$i], 'cargo_id' => $request->get('trInvolucrado')[$i]);
            }

            $data['tr_involucrados'] = json_encode($tr,JSON_NUMERIC_CHECK);
        }*/

        if($request->has('trbInvolucrado'))
            $data['tr_involucrados'] = json_encode($request->get('trbInvolucrado'),JSON_NUMERIC_CHECK);



        //Circunstancias
        if($request->get('jornada_id') != '')
            $data['jornada_id'] = $request->get('jornada_id');

        $data['naturaleza'] = $request->get('naturaleza');
        $data['actividad'] = $request->get('actividad');
        $data['equipo'] = $request->get('equipo');
        $data['parte_equipo'] = $request->get('parte_equipo');
        $data['lugar'] = $request->get('lugar');
        $data['producto'] = $request->get('producto');
        $data['des_situacion'] = $request->get('des_situacion');

        //Perdidas
        if($request->has('parte_afectada'))
            $data['partes_afectas'] = json_encode($request->get('parte_afectada'),JSON_NUMERIC_CHECK);

        if($request->has('entidad'))
            $data['entidad'] = json_encode($request->get('entidad'),JSON_NUMERIC_CHECK);

        if($request->has('consecuencia'))
            $data['consecuencia'] = json_encode($request->get('consecuencia'),JSON_NUMERIC_CHECK);

        $data['dias_perdidos'] = $request->get('dias_perdidos');

        $data['cons_posibles'] = $request->get('cons_posibles');

        //daños

        if($request->has('d_materiales'))
            $data['entidad_sini_mat'] = json_encode($request->get('d_materiales'),JSON_NUMERIC_CHECK);

        $data['danios_mat'] = $request->get('danios_mat');
        $data['desc_danios_mat'] = $request->get('desc_danios_mat');

        if($request->has('d_ambientales'))
            $data['entidad_sini_amb'] = json_encode($request->get('d_ambientales'),JSON_NUMERIC_CHECK);

        $data['lugar_danios_amb'] = $request->get('danios_amb');
        $data['desc_danios_amb'] = $request->get('desc_danios_amb');

        $ok = $this->incidenteRepository->create($data);

        return new RedirectResponse(url('/incidente/edit/'.$ok->id));
    }

    public function getEdit($id = 0)
    {
        //$incidente = $this->incidenteRepository->find($id);

        $incidente = $this->incidenteRepository->getModel()
                    ->where('id',$id)
                    ->first()
                    ->load('contrato.operacion');

        $incidente->fecha = Timezone::toLocal($incidente->fecha,$this->timezone);

        $tipo_incidiente =  $this->enumTablesRepository->getEnumTables('Incidente')
                ->lists('name','id');

        $tipo_informe =  $this->enumTablesRepository->getEnumTables('Informe')
                ->lists('name','id');

        $consecuencias = $this->enumTablesRepository->getConsecuencias()
            ->lists('name','id');

        $partes_afectadas = $this->enumTablesRepository->getPartesAfectadas();
        //->lists('name','id');

        $entidades = $this->enumTablesRepository->getEntidades()
            ->lists('name','id');

        $jornadas = array('' => '[-- Seleccione --]') + $this->enumTablesRepository->getEnumTables('Jornada')
                ->lists('name','id');

        return view("incidente.edit")
            ->with('incidente',$incidente)
           // ->with('proyectos',$proyectos)
            ->with('tipo_incidente',$tipo_incidiente)
            ->with('tipo_informe',$tipo_informe)
            ->with('consecuencias',$consecuencias)
            ->with('partes_afectadas',$partes_afectadas)
            ->with('entidades',$entidades)
            ->with('jornadas',$jornadas)
            ->with('trabajadores',$this->getTrabajadores());


    }

    public function postEdit($id,Request $request)
    {
        //General
        $data['tipo_informe_id'] = Input::get('tipo_informe');
        $data['tipo_incidente_id'] = Input::get('tipo_incidente');
        $data['fecha'] = Timezone::toUTC(Input::get('fecha'),$this->timezone);
        $data['lugar'] = Input::get('lugar');
        $data['punto'] = Input::get('punto');
        $data['equipos'] = Input::get('equipos');
        $data['parte'] = Input::get('parte');
        $data['sector'] = Input::get('sector');

        if(Input::get('responsables') != '')
            $data['responsable_id'] = Input::get('responsables');

        if($request->has('trbAfectado'))
            $data['tr_afectados'] = json_encode($request->get('trbAfectado'),JSON_NUMERIC_CHECK);
        else
            $data['tr_afectados'] = json_encode(array(),JSON_NUMERIC_CHECK);

        if($request->has('trbInvolucrado'))
            $data['tr_involucrados'] = json_encode($request->get('trbInvolucrado'),JSON_NUMERIC_CHECK);
        else
            $data['tr_involucrados'] = json_encode(array(),JSON_NUMERIC_CHECK);

        //Circunstancias
        if($request->get('jornada_id') != '')
            $data['jornada_id'] = $request->get('jornada_id');
        $data['naturaleza'] = $request->get('naturaleza');
        $data['actividad'] = $request->get('actividad');
        $data['equipo'] = $request->get('equipo');
        $data['parte_equipo'] = $request->get('parte_equipo');
        $data['lugar'] = $request->get('lugar');
        $data['producto'] = $request->get('producto');
        $data['des_situacion'] = $request->get('des_situacion');

        //Perdidas
        if($request->has('parte_afectada'))
            $data['partes_afectas'] = json_encode($request->get('parte_afectada'),JSON_NUMERIC_CHECK);
        else
            $data['partes_afectas'] = json_encode(array(),JSON_NUMERIC_CHECK);

        if($request->has('entidad'))
            $data['entidad'] = json_encode($request->get('entidad'),JSON_NUMERIC_CHECK);
        else
            $data['entidad'] = json_encode(array(),JSON_NUMERIC_CHECK);

        if($request->has('consecuencia'))
            $data['consecuencia'] = json_encode($request->get('consecuencia'),JSON_NUMERIC_CHECK);
        else
            $data['consecuencia'] = json_encode(array(),JSON_NUMERIC_CHECK);

        $data['dias_perdidos'] = $request->get('dias_perdidos');


        $data['cons_posibles'] = $request->get('cons_posibles');

        //daños

        if($request->has('d_materiales'))
            $data['entidad_sini_mat'] = json_encode($request->get('d_materiales'),JSON_NUMERIC_CHECK);
        else
            $data['entidad_sini_mat'] = json_encode(array(),JSON_NUMERIC_CHECK);

        $data['danios_mat'] = $request->get('danios_mat');
        $data['desc_danios_mat'] = $request->get('desc_danios_mat');

        if($request->has('d_ambientales'))
            $data['entidad_sini_amb'] = json_encode($request->get('d_ambientales'),JSON_NUMERIC_CHECK);
        else
            $data['entidad_sini_amb'] = json_encode(array(),JSON_NUMERIC_CHECK);

        $data['lugar_danios_amb'] = $request->get('danios_amb');
        $data['desc_danios_amb'] = $request->get('desc_danios_amb');

        $this->incidenteRepository->update($data,$id);

        return new RedirectResponse(url('/incidente/edit/'.$id));
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


    public function postUploadFotos($id)
    {
        $fotos = array();

        if (Input::hasFile('fotos'))
        {
            $file           	= Input::file('fotos')[0];
            $destinationPath    = 'incidentes/';
            $destinationPathTumb    = 'incidentes/tumb/';
            $ext            	= $file->getClientOriginalExtension();
            $fullname       	= $file->getFilename();
            $hashname           = $id.'_'.date('His').'_'.md5($fullname).'.'.$ext;

            //$success =  $file->move($destinationPath,$hashname);

            $manager = new ImageManager(array('driver' => 'imagick'));

            $image = $manager->make($file->getRealPath());

            if($image->height() > 800)
            {
                $image->resize(null,800,function($constraint){
                    $constraint->aspectRatio();
                });
            }
            else if($image->width() > 800)
            {
                $image->resize(800,null,function($constraint){
                    $constraint->aspectRatio();
                });
            }

            $image->save($destinationPath.$hashname,100)
                  ->resize(null,320,function($constraint){
                      $constraint->aspectRatio();
                  })->save($destinationPathTumb.$hashname,100);

            $incidente_fotos = new IncidenteFotos;
            $incidente_fotos->incidente_id = $id;
            $incidente_fotos->archivo = $hashname;
            $incidente_fotos->directorio = $destinationPath;

            $attr = array('fullPath'=>$destinationPath.$hashname,'fullPathTumb'=>$destinationPathTumb.$hashname);

            $incidente_fotos->attributes = json_encode($attr);
            $incidente_fotos->save();

            $fotos['id'] = $incidente_fotos->id;
            $fotos['incidente'] = $incidente_fotos->incidente_id;
            $fotos['fotos']=json_decode($incidente_fotos->attributes);

        }
        Return Response::json($fotos);
    }

    public function getDeleteImage($id=0){

        $msg['success'] = false;

        if($id == 0)
            Return Response::json($msg);

        $foto = IncidenteFotos::find($id);

        if(is_null($foto))
            Return Response::json($msg);

        $foto->delete();
        $msg['success'] = true;

        Return Response::json($msg);
    }

    public function getMedidasSeguridad($id=0)
    {
        $inmediatas = IncidenteMedidasSeguridad::where('incidente_id',$id)
                   ->where('type','inmediata')->get();

        //dd($inmediata);
        /*$responsalbes = array();

        foreach($inmediata as $key=>$row){
            $responsalbes[] = $row->responsablesLbl;
        }

        dd($responsalbes);*/

        return view("incidente.partial_e.medidas")
                ->with('timezone',$this->timezone)
                ->with('incidente_id',$id)
                ->with('inmediatas',$inmediatas);
    }

    public function getAddAccion()
    {
        $incidente          =   Input::get('incidente');
        $type           =   Input::get('type');
        $title         =   "";

        switch($type)
        {
            case 'inmediata':
                $title = 'Acción Inmediata';
                break;
            case 'correctiva':
                $title = 'Acción Correctiva';
                break;
            case 'preventiva':
                $title = 'Acción Preventiva';
                break;
            default:
                $title = 'Acción';
                break;
        }

        return view('incidente.addAccion')
            ->with('incidente',$incidente)
            ->with('type',$type)
            ->with('title',$title);
    }

    public function postAddAccion($type,$incidente)
    {

        $date = \DateTime::createFromFormat('d/m/Y H:i:s',Input::get("fecComprometida") ." 23:59:59");

        $fecha = $date->format('Y-m-d H:i:s');//->setTimezone(new \DateTimeZone($this->timezone));//Carbon::parse($date);//->format('y-m-d H:i:s');
        $data["incidente_id"] = $incidente;
        $data["type"] = $type;
        $data["accion"] = Input::get("descripcion");
        $data["fecha_comprometida"] = Timezone::toUTC($fecha,$this->timezone);
        $data["responsables"] = json_encode( explode(",",Input::get("resp")),JSON_NUMERIC_CHECK);

        $success = 0;
        $msg = "";

        $success = $this->medidasSeguridadRepository->create($data);

        $success = !is_null($success);

        $msg = $success ? "La informacion de guardo correctamente." : "Error: No se pudo guardar la información" ;

        return Response::json(array(
            'success' => $success,
            'data'   => $msg
        ));

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
