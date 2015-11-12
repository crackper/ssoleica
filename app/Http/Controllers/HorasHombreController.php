<?php namespace SSOLeica\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
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
use SSOLeica\Core\Model\DetalleHorasHombre;
use SSOLeica\Core\Model\HorasHombre;
use SSOLeica\Core\Model\Month;
use SSOLeica\Core\Model\TrabajadorContrato;
use SSOLeica\Core\Repository\ContratoRepository;
use SSOLeica\Core\Repository\HorasHombreRepository;
use SSOLeica\Core\Repository\MonthRepository;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    private $pais;
    private $timezone;
    /**
     * @var MonthRepository
     */
    private $monthRepository;

    /**
     * @param OperacionRepository $operacionRepository
     * @param ContratoRepository $contratoRepository
     * @param HorasHombreRepository $horasHombreRepository
     * @param MonthRepository $monthRepository
     */
    public function __construct(OperacionRepository $operacionRepository,
                                ContratoRepository $contratoRepository,
                                HorasHombreRepository $horasHombreRepository,
                                MonthRepository $monthRepository){
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->operacionRepository = $operacionRepository;
        $this->contratoRepository = $contratoRepository;
        $this->horasHombreRepository = $horasHombreRepository;
        $this->pais = Session::get('pais_id');
        $this->timezone = Session::get('timezone');
        $this->monthRepository = $monthRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $query = $this->horasHombreRepository->getQueryHorasHombre($this->pais);

        $months = array('Enero'=>'Enero','Febrero'=>'Febrero','Marzo'=>'Marzo','Abril'=>'Abril','Mayo'=>'Mayo','Junio'=>'Junio','Julio'=>'Julio','Agosto'=>'Agosto','Septiembre'=>'Septiembre','Octubre'=>'Octubre','Noviembre'=>'Noviembre','Diciembre'=>'Diciembre');

        $cfg = (new GridConfig())
            ->setName("gridHorasHombre")
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
                    ->setName('total')
                    ->setLabel('Total Hs.')
                    ->setSortable(true),
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val,EloquentDataRow $row) {

                        $horas = $row->getSrc();

                        $icon_edit = "<a href='/horasHombre/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Horas Hombre'><span class='glyphicon glyphicon-pencil'></span> Editar</a>";
                        $icon_view = "<a href='/horasHombre/show/$val' data-toggle='tooltip' data-placement='left' title='Visualizar Horas Hombre'><span class='glyphicon glyphicon-eye-open'></span> Visualizar</a>";

                        return $horas->isOpen ? $icon_edit : $icon_view;
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
                                    ->setContent('<span class="glyphicon glyphicon-plus"></span> Registrar Horas Hombre')
                                    ->setTagName('a')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-warning btn-sm',
                                        'href' => '/horasHombre/create'
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
            ])
            ->setPageSize(12);

        $grid = new Grid($cfg);

        $text = "<h3>Horas Hombre</h3>";

        return view('horasHombre.index', compact('grid', 'text'));
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

        //dd($operaciones);
		return view('horasHombre.create')
                ->with('proyectos',$proyectos);
	}

    public function  postCreate(){

        $trabajadores = Input::get('trabajador');
        $horas = Input::get('horas');
        $month_id = Input::get('month');
        $contrato_id = Input::get('contrato');

        $data = $this->horasHombreRepository->registrar($month_id,$contrato_id,$trabajadores,$horas,$this->timezone);

        Session::flash('message', 'La información Registró Correctamente');

        return new RedirectResponse(url('horasHombre/edit/' . $data['id']));
    }

    public function getContratos($id = 0)
    {
        $query = $this->contratoRepository->getListsContrato($id);
        return  Response::json($query);
    }

    public function getMonths($id=0)
    {
        $data = $this->monthRepository->getMesesDisponibles($this->timezone,$id);

        $months = array();

        foreach($data as  $key => $row)
        {
            $months[$row->id] = $row->nombre;
        }

        return  Response::json($months);
    }

    public function getTrabajadorescontrato($contrato_id = 0,$mes_id = 0)
    {
        //$trabajadores = $this->contratoRepository->getTrabajadores($contrato_id);

        //dd($trabajadores[0]->trabajador->cargo->name);

        $trabajadores = $this->horasHombreRepository->getDetalleHoras($this->timezone ,$mes_id,$contrato_id);

        //dd($trabajadores);

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
	public function getShow($id)
	{
		dd('visualizar horas hombre');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id = 0)
	{
        if($id == 0)
            return new RedirectResponse(url('/horasHombre'));

		$horasHombre = $this->horasHombreRepository->getHeadHorasHombre($id);

        if( is_null($horasHombre))
            return new RedirectResponse(url('horasHombre/'));

        if(!$horasHombre->isOpen)
            return new RedirectResponse(url('horasHombre/show/' . $id));


        $trabajadores = $this->horasHombreRepository->getDetalleHorasHombre($id,$this->timezone);

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
	public function postUpdate($id)
	{
        $detalle = Input::get('detalle');
        $trabajadores = Input::get('trabajador');
        $horas = Input::get('horas');

        $data = $this->horasHombreRepository->actualizar($id,$detalle,$trabajadores,$horas);

        Session::flash('message', 'La información Registró Correctamente');

        return new RedirectResponse(url('horasHombre/edit/' . $id));
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
