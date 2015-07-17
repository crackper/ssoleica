<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\EloquentDataRow;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\SelectFilterConfig;
use SSOLeica\Core\Helpers\Timezone;
use SSOLeica\Core\Model\EstadisticaSeguridad;
use SSOLeica\Core\Repository\ContratoRepository;
use SSOLeica\Core\Repository\EstadisticasRepository;
use SSOLeica\Core\Repository\MonthRepository;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Zofe\Rapyd\DataForm\DataForm;

class EstadisticaSegController extends Controller {

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
     * @var MonthRepository
     */
    private $monthRepository;
    /**
     * @var EstadisticasRepository
     */
    private $estadisticasRepository;

    /**
     * @param OperacionRepository $operacionRepository
     * @param ContratoRepository $contratoRepository
     * @param MonthRepository $monthRepository
     * @param EstadisticasRepository $estadisticasRepository
     */
    public function __construct(OperacionRepository $operacionRepository,
                                ContratoRepository $contratoRepository,
                                MonthRepository $monthRepository,
                                EstadisticasRepository $estadisticasRepository)
    {
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->pais = Session::get('pais_id');
        $this->timezone = Session::get('timezone');
        $this->operacionRepository = $operacionRepository;
        $this->contratoRepository = $contratoRepository;
        $this->monthRepository = $monthRepository;
        $this->estadisticasRepository = $estadisticasRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $query = $this->estadisticasRepository->getQueryEstadisticasSeguridad($this->pais);

        $months = array('Enero'=>'Enero','Febrero'=>'Febrero','Marzo'=>'Marzo','Abril'=>'Abril','Mayo'=>'Mayo','Junio'=>'Junio','Julio'=>'Julio','Agosto'=>'Agosto','Septiembre'=>'Septiembre','Octubre'=>'Octubre','Noviembre'=>'Noviembre','Diciembre'=>'Diciembre');

        $cfg = (new GridConfig())
            ->setName("gridEstadisticas")
            ->setDataProvider(
                new EloquentDataProvider($query)
            )->setColumns([
                (new IdFieldConfig)->setLabel('#'),
                (new FieldConfig)
                    ->setName('year')
                    ->setLabel('Año')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)->setOperator(FilterConfig::OPERATOR_EQ)
                    ),
                (new FieldConfig)
                    ->setName('mes')
                    ->setLabel('Mes')
                    ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions($months)
                            ->setFilteringFunc(function($val,EloquentDataProvider $provider){
                                $provider->getBuilder()->where('month.nombre','=',$val);
                            })
                    ),
                (new FieldConfig)
                    ->setName('isOpen')
                    ->setLabel('Estado')
                    ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions(array('true'=>'Abierto','false'=>'Cerrado'))
                            ->setFilteringFunc(function($val,EloquentDataProvider $provider){
                                $provider->getBuilder()->where('isOpen','=',$val);
                            })
                    )
                    ->setCallback(function ($val) {
                        return $val == true ? "<span class='glyphicon glyphicon-folder-open'></span>  Abierto":"<span class='glyphicon glyphicon-folder-close'></span>  Cerrado";
                    }),
                (new FieldConfig)
                    ->setName('proyecto')
                    ->setLabel('Proyecto')
                    ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions($this->operacionRepository->getOperaciones(Session::get('pais_id'))->lists('nombre_operacion','id'))
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where('operacion.id','=',$val);
                            })
                    ),
                (new FieldConfig)
                    ->setName('contrato')
                    ->setLabel('Contrato')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where('contrato.nombre_contrato','like','%'.$val.'%');
                            })

                    ),
                (new FieldConfig)
                    ->setName('dotacion')
                    ->setLabel('Dotación')
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('dias_perdidos')
                    ->setLabel('Días Perdidos')
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('inc_stp')
                    ->setLabel('Inc. STP')
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('inc_ctp')
                    ->setLabel('Inc. CTP')
                    ->setSortable(true),
                (new FieldConfig)
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val,EloquentDataRow $row) {

                        $std = $row->getSrc();

                        $icon_edit = "<a href='/estadisticas/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Estadisticas'><span class='glyphicon glyphicon-pencil'></span> Editar</a>";
                        $icon_view = "<a href='/estadisticas/show/$val' data-toggle='tooltip' data-placement='left' title='Visualizar Horas Hombre'><span class='glyphicon glyphicon-eye-open'></span> Visualizar</a>";

                        return $std->isOpen ? $icon_edit : $icon_view;
                    })
            ])
            ->setComponents([
                (new THead)
                    ->setComponents([
                        new ColumnHeadersRow,
                        new FiltersRow,
                        (new OneCellRow)
                            ->setRenderSection(RenderableRegistry::SECTION_BEGIN)
                            ->setComponents([
                                (new RecordsPerPage)->setVariants([6,12,24,26,48]),

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
                            ->setContent('<span class="glyphicon glyphicon-plus"></span> Registrar Estadisticas')
                            ->setTagName('a')
                            ->setRenderSection(RenderableRegistry::SECTION_END)
                            ->setAttributes([
                                'class' => 'btn btn-warning btn-sm',
                                'href' => '/estadisticas/create'
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
            ])->setPageSize(12);

        $grid = new Grid($cfg);

        $text = "<h3>Estadisticas de Seguridad</h3>";

        return view('estadisticaseg.index', compact('grid', 'text'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        /*$date = new \DateTime('2015-07-01 11:28:59');
        $date2 = new \DateTime('2015-07-01 11:28:59',new \DateTimeZone( $this->timezone));
        $date3 = new \DateTime('2015-07-01 11:28:59',new \DateTimeZone( 'America/Santiago'));

        $data['date'] = $date;
        $data['chile'] = $date3->setTimezone(new \DateTimeZone( 'UTC'));
        $data['peru'] = $date2->setTimezone(new \DateTimeZone( 'UTC'));
                        //->setTimezone(new \DateTimeZone( 'America/Santiago'));*/

        //dd($data);

        $proyectos = array('' => '[-- Seleccione --]') + $this->operacionRepository->getOperaciones($this->pais)
                ->lists('nombre_operacion','id');

        return view('estadisticaseg.create')
                    ->with('proyectos',$proyectos);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
        $data['month_id'] = Input::get('month_id');
        $data['contrato_id'] = Input::get('contrato_id');

        $month = $this->monthRepository->find(Input::get('month_id'));

        $data['fecha_inicio'] = Timezone::toUTC($month->fecha_inicio,$this->timezone);

        $fechaFin = Timezone::toUTC($month->fecha_fin,$this->timezone);

        $data['fecha_fin'] = Timezone::addTime($fechaFin,'P'.$month->plazo.'D');
        $data['dotacion'] = Input::get('dotacion');
        $data['dias_perdidos'] = Input::get('cantDiasPerdidos');
        $data['inc_stp'] = Input::get('stp');
        $data['inc_ctp'] = Input::get('ctp');

        $create = $this->estadisticasRepository->create($data);

        Session::flash('message', 'La información Registró Correctamente');

        return new RedirectResponse(url('/estadisticas/edit/' . $create->id));
	}

    public function getContratos($id = 0)
    {
        $query = $this->contratoRepository->getListsContrato($id);
        return  Response::json($query);
    }

    public function getMonths($id=0)
    {
        $data = $this->monthRepository->getMesesDisponiblesForEstadisticas($this->timezone,$id);

        $months = array();

        foreach($data as  $key => $row)
        {
            $months[$row->id] = $row->nombre;
        }

        return  Response::json($months);
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
        if($id == 0)
            return new RedirectResponse(url('/estadisticas'));

        $std = $this->estadisticasRepository->getEstadistica($id);

        if(is_null($std))
            return new RedirectResponse(url('/estadisticas'));


        return view('estadisticaseg.edit')
                ->with('std',$std);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate($id)
	{

        $data['dotacion'] = Input::get('dotacion');
        $data['dias_perdidos'] = Input::get('cantDiasPerdidos');
        $data['inc_stp'] = Input::get('stp');
        $data['inc_ctp'] = Input::get('ctp');

        //dd($data);

        $this->estadisticasRepository->update($data,$id);

        Session::flash('message', 'La información Registró Correctamente');

        return new RedirectResponse(url('/estadisticas/edit/' . $id));
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
