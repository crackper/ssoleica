<?php namespace SSOLeica\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\SelectFilterConfig;
use SSOLeica\Core\Model\Contrato;
use SSOLeica\Core\Model\ProrrogaContrato;
use SSOLeica\Core\Repository\ContratoRepository;
use SSOLeica\Core\Repository\HorasHombreRepository;
use SSOLeica\Core\Repository\MonthRepository;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Core\Repository\ProrrogaContratoRepository;
use SSOLeica\Core\Repository\TrabajadorRepository;
use SSOLeica\Events\ContratoWasSaved;
use SSOLeica\Http\Requests;
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
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\IdFieldConfig;

use Illuminate\Http\Request;
use Zofe\Rapyd\DataForm\DataForm;
use SSOLeica\Core\Helpers\Timezone;

class ContratoController extends Controller {


    /**
     * @var TrabajadorRepository
     */
    private $trabajador_repository;
    /**
     * @var OperacionRepository
     */
    private $operacion_repository;
    /**
     * @var ContratoRepository
     */
    private $contrato_repository;
    /**
     * @var MonthRepository
     */
    private $month_repository;
    /**
     * @var HorasHombreRepository
     */
    private $horashombre_repository;

    private $pais;
    private $timezone;
    /**
     * @var ProrrogaContratoRepository
     */
    private $prorrogacontrato_Repository;


    /**
     * @param TrabajadorRepository $trabajador_repository
     * @param OperacionRepository $operacion_repository
     * @param ContratoRepository $contrato_repository
     * @param MonthRepository $month_repository
     */
    public function __construct(TrabajadorRepository $trabajador_repository,
                                OperacionRepository $operacion_repository,
                                ContratoRepository $contrato_repository,
                                MonthRepository $month_repository,
                                HorasHombreRepository $horashombre_repository,
                                ProrrogaContratoRepository $prorrogacontrato_Repository
                                )
    {
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->trabajador_repository = $trabajador_repository;
        $this->operacion_repository = $operacion_repository;
        $this->contrato_repository = $contrato_repository;
        $this->month_repository = $month_repository;
        $this->horashombre_repository = $horashombre_repository;
        $this->pais = Session::get('pais_id');
        $this->timezone = Session::get('timezone');
        $this->prorrogacontrato_Repository = $prorrogacontrato_Repository;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $query = $this->contrato_repository->getContratos(Session::get('pais_id'));

        $cfg = (new GridConfig())
            ->setName('gridOperaciones')
            ->setDataProvider(
                new EloquentDataProvider($query)
            )
            ->setColumns([
                (new IdFieldConfig)
                    ->setLabel('#'),
                (new FieldConfig)
                    ->setName('proyecto')
                    ->setLabel('Proyecto')
                    ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions($this->operacion_repository->getOperaciones(Session::get('pais_id'))->lists('nombre_operacion','id'))
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where('operacion_id','=',$val);
                            })
                    ),
                (new FieldConfig)
                    ->setName('nombre_contrato')
                    ->setLabel('Contrato')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(nombre_contrato)'), 'like', '%' . strtoupper($val) . '%');
                            })
                    ),
                (new FieldConfig)
                    ->setName('gerencia')
                    ->setLabel('Gerencia')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(gerencia)'), 'like', '%' . strtoupper($val) . '%');
                            })
                    ),
                (new FieldConfig)
                    ->setName('supervisor')
                    ->setLabel('Ing./Supervisor')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(s.app_paterno)'), 'like', '%'. strtoupper( $val) .'%')
                                    ->orWhere(DB::raw('upper(s.nombre)'), 'like', '%'. strtoupper( $val) .'%');
                            })
                    )
                ,
                (new FieldConfig)
                    ->setName('apr')
                    ->setLabel('APR')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(atr.app_paterno)'), 'like', '%'. strtoupper( $val) .'%')
                                    ->orWhere(DB::raw('upper(atr.nombre)'), 'like', '%'. strtoupper( $val) .'%');
                            })
                    )
                ,
                (new FieldConfig)
                    ->setName('exist_cphs')
                    ->setLabel('CPHS')
                    ->setSortable(true)
                    ->setCallback(function ($val) {
                        return $val == 1 ? "<span class='glyphicon glyphicon-ok'></span>":"<span class='glyphicon glyphicon-remove'></span>";
                    })
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions(array('0'=>'No','1' => 'Si' ))
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where('exist_cphs','=',$val);
                            })
                    ),
                (new FieldConfig)
                    ->setName('exist_subcontrato')
                    ->setLabel('Sub Contratos')
                    ->setSortable(true)
                    ->setCallback(function ($val) {
                        return $val == 1 ? "<span class='glyphicon glyphicon-ok'></span>":"<span class='glyphicon glyphicon-remove'></span>";
                    })
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions(array('0'=>'No','1' => 'Si' ))
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where('exist_subcontrato','=',$val);
                            })
                    ),
                /*(new FieldConfig)
                    ->setName('is_activo')
                    ->setLabel('Activo')
                    ->setSortable(true)
                    ->setCallback(function ($val) {
                        return $val == 1 ? "<span class='glyphicon glyphicon-ok'></span>":"<span class='glyphicon glyphicon-remove'></span>";
                    })
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions(array('0'=>'Inactivo','1' => 'Activo' ))
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where('is_activo','=',$val);
                            })
                    ),*/
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val) {

                        $icon_edit = "<a href='/contrato/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Contrato'><span class='glyphicon glyphicon-pencil'></span></a>";
                        $icon_remove = "<a href='/contrato/delete/$val' data-toggle='tooltip' data-placement='left' title='Eliminar Contrato' ><span class='glyphicon glyphicon-trash'></span></a>";
                        $icon_ampliar = "<a href='/contrato/solicita-ampliar-contrato/$val' data-toggle='tooltip' data-placement='left' title='Solicitar Ampliación' ><span class='fa fa-paperclip'></span></a>";

                        return  $icon_edit . ' ' . $icon_remove.' '.$icon_ampliar;
                    })

            ])
            ->setComponents([
                (new THead)
                    ->setComponents([
                        (new ColumnHeadersRow),
                        (new FiltersRow),
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
                                    ->setContent('<span class="glyphicon glyphicon-plus"></span> Registrar Nuevo Contrato')
                                    ->setTagName('a')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-warning btn-sm',
                                        'href' => '/contrato/create'
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

        $text = "<h3>Información de Contratos</h3>";

        return view('contrato.index', compact('grid', 'text'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function anyCreate()
	{
        $trabajadores = $this->GetTrabajadores();

		$form = DataForm::source(new Contrato);

        $form->add('operacion_id', 'Proyecto','select')->option('','[-- Seleccione --]')->options($this->operacion_repository->getOperaciones(Session::get('pais_id'))->lists('nombre_operacion','id'))->rule('required');
        $form->add('nombre_contrato','Nombre Contrato','text')->rule('required|min:5');
        $form->add('gerencia','Gerencia','text')->rule('required|min:5');
        $form->add('jorn_max_trabajador','Hrs. Jornada Maxima/Mes','text')->rule('required|integer');
        $form->add('dias_trabajo','Dias de Trabajo.','text')->rule('required|integer');
        $form->add('hrs_max_dia','Hrs. Maximo/Dia.','text')->rule('required|integer');
        $form->add('dias_descanso','Dias de Descanso.','text')->rule('required|integer');
        $form->add('adm_contrato_id','Adm. de Contrato','select')
            ->options($trabajadores)
            ->rule('required')
            ->attr('data-live-search','true');
        $form->add('supervisor_id','Ingeniero/Supervisor','select')
            ->options($trabajadores)
            ->rule('required')
            ->attr('data-live-search','true');
        $form->add('asesor_prev_riesgos_id','Asesor Prevención de Riesgos','select')
            ->options($trabajadores)
            ->rule('required')
            ->attr('data-live-search','true');
        $form->add('fecha_inicio','Fecha de Inicio', 'date')->format('d/m/Y', 'es')->rule('required');
        $form->add('fecha_fin','Fecha de Fin', 'date')->format('d/m/Y', 'es')->rule('required');
        $form->add('exist_cphs','CPHS','checkbox');
        $form->add('exist_subcontrato','Sub Contratos','checkbox');
        $form->add('is_activo','Activo','checkbox');
        $form->add('observaciones','Observaciones', 'redactor');

        $form->submit('Guardar');
        $form->link("/contrato","Cancelar");

        $form->saved(function () use ($form) {

            Session::flash('message', 'La información del Contrato se Registró Correctamente');
            return new RedirectResponse(url('contrato/edit/'.$form->model->id));
        });

        $form->build();

        return $form->view('contrato.create', compact('form'));
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function anyEdit($id = 0)
	{
        if($id == 0)
            return new RedirectResponse(url('/contrato'));

        $contrato= $this->contrato_repository->getContrato($id,Session::get('pais_id'));

        //dd($contrato);

        //$contrato = $this->contrato_repository->find($id);

        if(is_null($contrato))
        {
            return new RedirectResponse(url('/contrato'));
        }

        $trabajadores = $this->GetTrabajadores();

        $form = DataForm::source($contrato);

        $form->add('operacion_id', 'Proyecto','select')->option('','[-- Seleccione --]')->options($this->operacion_repository->getOperaciones(Session::get('pais_id'))->lists('nombre_operacion','id'))->rule('required');
        $form->add('nombre_contrato','Nombre Contrato','text')->rule('required|min:5');
        $form->add('gerencia','Gerencia','text')->rule('required|min:5');
        $form->add('jorn_max_trabajador','Hrs. Jornada Maxima/Mes','text')->rule('required|integer');
        $form->add('dias_trabajo','Dias de Trabajo.','text')->rule('required|integer');
        $form->add('hrs_max_dia','Hrs. Maximo/Dia.','text')->rule('required|integer');
        $form->add('dias_descanso','Dias de Descanso.','text')->rule('required|integer');
        $form->add('adm_contrato_id','Adm. de Contrato','select')
            ->options($trabajadores)
            ->rule('required')
            ->attr('data-live-search','true');
        $form->add('supervisor_id','Ingeniero/Supervisor','select')
            ->options($trabajadores)
            ->rule('required')
            ->attr('data-live-search','true');
        $form->add('asesor_prev_riesgos_id','Asesor Prevención de Riesgos','select')
            ->options($trabajadores)
            ->rule('required')
            ->attr('data-live-search','true');
        $form->add('fecha_inicio','Fecha de Inicio', 'date')->format('d/m/Y', 'es')->rule('required');
        $form->add('fecha_fin','Fecha de Fin', 'date')->format('d/m/Y', 'es')->rule('required');
        $form->add('exist_cphs','CPHS','checkbox');
        $form->add('exist_subcontrato','Sub Contratos','checkbox');
        $form->add('is_activo','Activo','checkbox');
        $form->add('observaciones','Observaciones', 'redactor');

        $form->submit('Guardar');
        $form->link("/contrato","Cancelar");

        $form->saved(function () use ($form) {

            Session::flash('message', 'La información del Contrato se Registró Correctamente');
            return new RedirectResponse(url('contrato/edit/'.$form->model->id));
        });

        $form->build();

        return $form->view('contrato.edit', compact('form'));
	}

    public function getTrabajadoreslist()
    {
        $q = Input::get('q');
        $pais_id = Session::get('pais_id');

        return $this->trabajador_repository->getTrabajadoresListAC($q,$pais_id);
    }

    /**
     * @return array
     */
    public function GetTrabajadores()
    {
        $query = $this->trabajador_repository->getTrabajadoresList(Session::get('pais_id'));

        $trabajadores = array();

        $trabajadores[''] = '[-– Seleccione –-]';

        foreach ($query as $row) {
            $trabajadores[$row->id] = $row->nombre . " " . $row->app_paterno . " " . $row->app_materno;
        }
        return $trabajadores;
    }

    public function anySolicitaAmpliarContrato($id = 0)
    {

        if($id == 0 || is_null(Auth::user()->trabajador_id))
            return new RedirectResponse(url('/contrato'));

        $data = $this->month_repository->getMesesAmpliacion(Auth::user()->trabajador_id,$id);

        $months = array();

        $months[''] = '[-– Seleccione –-]';

        foreach($data as  $key => $row)
        {
            $months[$row->id] = $row->nombre;
        }

        $contrato = $this->contrato_repository->find($id);

        $form = DataForm::create();
        $form->hidden('contrato_id','')->rule('required')->insertValue($id);
        $form->text('contrato','Contrato')
            ->attr('disabled','disabled')
            ->insertValue($contrato->nombre_contrato);
        $form->date('fecha_cierre','Fecha de Cierre')->format('d/m/Y', 'es')->rule('required');
        $form->select('mes_id','Mes')
            ->options($months)
            ->rule('required')
            ->attr('data-live-search','true');
        $form->textarea('comentario','Comentario');
        $form->submit('Guardar');
        $form->link("/contrato","Cancelar");

        $form->passed(function() use ($form)
        {
            $ampliacion = new ProrrogaContrato();
            $ampliacion->solicita_id = Auth::user()->trabajador_id;
            $ampliacion->contrato_id = Input::get('contrato_id');
            $ampliacion->month_id= Input::get('mes_id');

            $fecha = Carbon::createFromFormat('d/m/Y H:i:s',Input::get('fecha_cierre') .' 23:59:59',$this->timezone);
            $ampliacion->fecha_cierre = $fecha->timezone('UTC');

            $ampliacion->comentario = Input::get('comentario');

            $ampliacion->save();

            Session::flash('message', 'La Solicitud a sido registrada, esta pendiente de aprobación');

            //return new RedirectResponse(url('/contrato'));

            $form->message("La Solicitud a sido registrada, esta pendiente de aprobación");
            $form->link("/contrato", "Ir a Contratos");

        });

        return $form->view('contrato.ampliacion', compact('form'));
    }

    public  function getAmpliacionPendiente()
    {
        $query = $this->prorrogacontrato_Repository->getProrrogasPendientes();

        $cfg = (new GridConfig())
            ->setName('gridAmpliacones')
            ->setDataProvider(
                new EloquentDataProvider($query)
            )
            ->setColumns([
                (new IdFieldConfig)->setLabel('#'),
                (new FieldConfig)
                    ->setName('contrato')
                    ->setLabel('Contato')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where(DB::raw('upper(c.nombre_contrato)'),'like','%'.strtoupper($val).'%');
                            })
                    ),
                (new FieldConfig)
                    ->setName('mes')
                    ->setLabel('Mes')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where(DB::raw('upper(m.nombre)'),'like','%'.strtoupper($val).'%');
                            })
                    ),
                (new FieldConfig)
                    ->setName('fecha_cierre')
                    ->setLabel('Fecha de Cierre')
                    ->setSortable(true)
                    ->setCallback(function ($val) {
                        return Carbon::createFromFormat('Y-m-d H:i:s',$val,'UTC')->timezone($this->timezone)->format('d/m/Y');
                    }),
                (new FieldConfig())
                    ->setName('solicita')
                    ->setLabel('Solicita')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(s.app_paterno)'), 'like', '%' . strtoupper($val) . '%')
                                    ->orWhere(DB::raw('upper(s.app_materno)'), 'like', '%' . strtoupper($val) . '%')
                                    ->orWhere(DB::raw('upper(s.nombre)'), 'like', '%' . strtoupper($val) . '%');
                            })
                    ),
                (new FieldConfig)
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val) {

                        $icon_ampliar = "<a href='/contrato/aprobar-ampliar-contrato/$val' data-toggle='tooltip' data-placement='left' title='Aprobar Ampliación' class='btn btn-xs btn-block btn-success' ><span class='fa  fa-thumbs-o-up'></span> Aprobar</a>";

                        return  $icon_ampliar;
                    })
            ])
            ->setComponents([
                (new THead)
                    ->setComponents([
                        (new ColumnHeadersRow),
                        (new FiltersRow),
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
                                    ])
                            ]),
                        (new HtmlTag)
                            ->setContent('&nbsp;')
                            ->setRenderSection(RenderableRegistry::SECTION_END)
                            ->setTagName('span')
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

        $text = "<h3>Ampliación de Contratos Pendientes de Aprobación</h3>";

        return view('contrato.ampliacion_pendiente', compact('grid', 'text'));
    }
}
