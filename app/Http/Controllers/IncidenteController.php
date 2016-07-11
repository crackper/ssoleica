<?php namespace SSOLeica\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\SelectFilterConfig;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
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
use HTML;
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
        $data = $this->incidenteRepository->getIncidentes($this->pais);

        //dd($data->get());

        $cfg = (new GridConfig())
            ->setName("gridIcidentes")
            ->setDataProvider(
                new EloquentDataProvider($data)
            )
            ->setColumns([
                (new IdFieldConfig)->setLabel('#'),
                (new FieldConfig)
                    ->setName('fecha')
                    ->setLabel('Fecha')
                    ->setSortable(true)
                    ->setSorting(Grid::SORT_DESC)
                    ->setCallback(function ($val) {
                        return "<span class='fa fa-calendar'></span> " . Timezone::toLocal($val,$this->timezone,'d/m/Y H:m');
                    }),
                (new FieldConfig)
                    ->setName("operacion")
                    ->setLabel("Proyecto")
                    ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions($this->operacionRepository->getOperaciones($this->pais)->lists('nombre_operacion','id'))
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where('operacion_id','=',$val);
                            })
                    ),
                (new FieldConfig)
                    ->setName('contrato')
                    ->setLabel('Contrato')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(c.nombre_contrato)'), 'like', '%' . strtoupper($val) . '%');
                            })
                    ),
                (new FieldConfig)
                    ->setName('tipo_informe')
                    ->setLabel('Informe')
                    ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions($this->enumTablesRepository->getInformes()->lists("name",'id'))
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()->where('tipo_informe_id', '=', $val);
                            })
                    ),
                (new FieldConfig)
                    ->setName('tipo_incidente')
                    ->setLabel('Incidente')
                    ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions($this->enumTablesRepository->getIncidentes()->lists("name",'id'))
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()->where('tipo_incidente_id', '=', $val);
                            })
                    ),
                (new FieldConfig)
                    ->setName('lugar')
                    ->setLabel('Lugar')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(lugar)'), 'like', '%' . strtoupper($val) . '%');
                            })
                    ),
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val) {

                        $icon_edit = "<a href='/incidente/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Incidente'><span class='fa fa-edit'></span></a>";
                        $icon_remove = "<a href='/incidente/delete/$val' data-toggle='tooltip' data-placement='left' title='Eliminar Incidente' ><span class='glyphicon glyphicon-trash'></span></a>";

                        return $icon_edit . ' ' . $icon_remove;
                    })
            ])
            ->setComponents([
                (new THead)
                    ->setComponents([
                        (new ColumnHeadersRow),
                        (new FiltersRow)
                            ->addComponents([
                                (new RenderFunc(function () {
                                    return HTML::style('js/daterangepicker/daterangepicker-bs3.css')
                                    . HTML::script('js/moment/moment-with-locales.js')
                                    . HTML::script('js/daterangepicker/daterangepicker.js')
                                    . "<style>
                                                .daterangepicker td.available.active,
                                                .daterangepicker li.active,
                                                .daterangepicker li:hover {
                                                    color:black !important;
                                                    font-weight: bold;
                                                }
                                           </style>";
                                }))
                                    ->setRenderSection('filters_row_column_fecha'),
                                (new DateRangePicker)
                                    ->setName('fecha')
                                    ->setRenderSection('filters_row_column_fecha')
                                    ->setDefaultValue(['2016-01-01', date('Y-m-d')])
                            ])
                        ,
                        (new OneCellRow)
                            ->setRenderSection(RenderableRegistry::SECTION_BEGIN)
                            ->setComponents([
                                (new RecordsPerPage)
                                    ->setVariants([10,15,20,30,40,50]),
                                new ColumnsHider,
                                (new HtmlTag)
                                    ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filtrar')
                                    ->setTagName('button')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-success btn-sm'
                                    ]),
                                (new HtmlTag)
                                    ->setContent('&nbsp;')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setTagName('span'),
                                (new HtmlTag)
                                    ->setContent('<span class="glyphicon glyphicon-plus"></span> Registrar Nuevo Incidente')
                                    ->setTagName('a')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-warning btn-sm',
                                        'href' => '/incidente/create'
                                    ])
                            ])
                    ]),
                (new TFoot)
                    ->addComponents([
                        new Pager,
                        (new HtmlTag)
                            ->setAttributes(['class' => 'pull-right'])
                            ->addComponent(new ShowingRecords)
                    ])
            ])->setPageSize(10);

        $grid = new Grid($cfg);

        $text = "<h3>Información de Incidentes</h3>";

        $timezone = $this->timezone;

        return view('incidente.index', compact('grid', 'text','timezone'));
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
            $destinationPathRpt    = 'incidentes/rpt/';

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
                  })->save($destinationPathTumb.$hashname,100)
                  ->resize(null,160,function($constraint){
                      $constraint->aspectRatio();
                  })->save($destinationPathRpt.$hashname,100);

            $incidente_fotos = new IncidenteFotos;
            $incidente_fotos->incidente_id = $id;
            $incidente_fotos->archivo = $hashname;
            $incidente_fotos->directorio = $destinationPath;

            $attr = array('fullPath'=>$destinationPath.$hashname,
                          'fullPathTumb'=>$destinationPathTumb.$hashname,
                          'fullPathRpt'=>$destinationPathRpt.$hashname);

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
                   ->where('type','inmediata')
                    ->orderBy('created_at', 'asc')->get();

        $correctivas = IncidenteMedidasSeguridad::where('incidente_id',$id)
            ->where('type','correctiva')
            ->orderBy('created_at', 'asc')->get();

        $preventivas = IncidenteMedidasSeguridad::where('incidente_id',$id)
            ->where('type','preventiva')
            ->orderBy('created_at', 'asc')->get();


        return view("incidente.partial_e.medidas")
                ->with('timezone',$this->timezone)
                ->with('incidente_id',$id)
                ->with('inmediatas',$inmediatas)
                ->with('correctivas',$correctivas)
                ->with('preventivas',$preventivas);
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

    public function getEditAccion($id = 0)
    {
        $accion = $this->medidasSeguridadRepository->find($id);

        return view('incidente.editAccion')
            ->with('accion',$accion)
            ->with('timezone',$this->timezone);
    }

    public function postEditAccion($id=0)
    {
        $date = \DateTime::createFromFormat('d/m/Y H:i:s',Input::get("fecComprometida") ." 23:59:59");

        $fecha = $date->format('Y-m-d H:i:s');
        $data["accion"] = Input::get("descripcion");
        $data["fecha_comprometida"] = Timezone::toUTC($fecha,$this->timezone);
        $data["responsables"] = json_encode( explode(",",Input::get("resp")),JSON_NUMERIC_CHECK);

        $success = 0;
        $msg = "";

        $success = $this->medidasSeguridadRepository->update($data,$id);

        $success = !is_null($success);

        $msg = $success ? "La informacion de guardo correctamente." : "Error: No se pudo guardar la información" ;

        return Response::json(array(
            'success' => $success,
            'data'   => $msg
        ));
    }


    public function getDeleteAccion($id)
    {

        $success = 0;
        $msg = "";

        $incidente = $this->medidasSeguridadRepository->find($id);

        if(is_null($incidente))
            return Response::json(array(
                'success' => $success,
                'data'   => "Esta Accion no existe."
            ));

        $success = $this->medidasSeguridadRepository->delete($incidente->id);

        $msg = $success ? "La Acción se eliminó correctamente." : "Error: No se puede eliminar esta Acción" ;

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

    public function  getReport($id=0)
    {
        //dd(getcwd());

        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=downloaded.pdf");

        define ("JAVA_HOSTS", "127.0.0.1:8080");
        define ("JAVA_SERVLET", "/JavaBridge/JavaBridge.phpjavabridge");

        //require_once("./Java.inc");
        require_once("http://127.0.0.1:8080/JavaBridge/java/Java.inc");

        session_start();

        $here = getcwd();

        $ctx = java_context()->getServletContext();

        $birtReportEngine =        java("org.eclipse.birt.php.birtengine.BirtEngine")->getBirtEngine($ctx);
        java_context()->onShutdown(java("org.eclipse.birt.php.birtengine.BirtEngine")->getShutdownHook());


        try{

            $report = $birtReportEngine->openReportDesign("${here}/Incidente_ok.rptdesign");
            $task = $birtReportEngine->createRunAndRenderTask($report);

            $task->setParameterValue("IdIncidente", new \java("java.lang.Integer", $id));

            /*$path = new \Java("java.lang.String", $here);

            $task->setParameterValue("path",$path);*/

            $taskOptions = new \java("org.eclipse.birt.report.engine.api.PDFRenderOption");
            $outputStream = new \java("java.io.ByteArrayOutputStream");

            $taskOptions->setOutputStream($outputStream);

            $taskOptions->setOption("pdfRenderOption.pageOverflow", "pdfRenderOption.fitToPage");
            $taskOptions->setOption("pdfRenderOption.setEmbededFont", false);
            //$taskOptions->setOption("pdfRenderOption.setFontDirectory", "/Library/Fonts");

            //dd($taskOptions);


            $taskOptions->setOutputFormat("pdf");

            $task->setRenderOption( $taskOptions );
            $task->run();
            $task->close();

        } catch (JavaException $e) {
            echo $e; //"Error Calling BIRT";

        }

        echo java_values($outputStream->toByteArray());

    }

}
