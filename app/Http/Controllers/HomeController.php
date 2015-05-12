<?php namespace SSOLeica\Http\Controllers;

use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use SSOLeica\Core\Model\EnumTables;
use SSOLeica\Core\Model\TrabajadorOperacion;
use SSOLeica\Core\Model\EnumCategories;
use SSOLeica\Core\Repository\TrabajadorRepository as Trabajador;
use Grids;
use HTML;
use Illuminate\Support\Facades\DB;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\SelectFilterConfig;
//ªªªªª
use Illuminate\Support\Facades\Config;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\TotalsRow;
use Zofe\Rapyd\DataForm\DataForm;


//use Nayjest\Grids\EloquentDataProvider;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

    /**
     * @var TrabajadorRepository
     */
    private $trabajador;

    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Trabajador $trabajador)
	{
        $this->middleware('workspace');
        $this->trabajador = $trabajador;
    }

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
       // $trabajador = Trabajador::find(1)->load('profesion','operaciones.operacion.examenes_medicos.examen');

        //$enum = EnumTables::find(14)->load('trabajadores.profesion');
        //$operacion = TrabajadorOperacion::find(1);

        //dd($trabajador);

		return view('home');

        //return \Response::json($this->trabajadorRepository->find('1')->load('profesion'));

        //dd($this->trabajadorRepository->getModel()->where('apellidos', 'like', '%u%')->get()->load('profesion','pais'));


        //dd($this->trabajador->find('1')->load('profesion'));
	}

    public function grid()
    {

        $query = $this->trabajador->getTrabajadores();

        $query_cargos = EnumTables::where('type','=','Cargo')->get();
        $cargos = array();

        foreach($query_cargos as $row)
        {
            $cargos[$row->id] = $row->name;
        }

        //dd($cargos);

        $estado = array('Soltero'=>'Soltero','Casado'=>'Casado', 'Viudo'=>'Viudo','Divorciado'=>'Divorcioado','Conviviente'=>'Conviviente');
        //dd($estado);
        $cfg = (new  GridConfig())
            ->setDataProvider(
                new EloquentDataProvider($query)
            )
            ->setColumns([
                new IdFieldConfig,
                (new FieldConfig)
                    ->setName('dni')
                    ->setLabel('DNI')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    ),
                (new FieldConfig)
                    ->setName('nombre')
                    ->setLabel('Nombres')
                    ->setCallback(function ($val) {
                        return "<span class='glyphicon glyphicon-user'></span> {$val}";
                    })
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    ),
                (new FieldConfig)
                    ->setName('apellidos')
                    ->setLabel('Apellidos')
                    ->setSortable(true)
                    ->setSorting(Grid::SORT_ASC)
                    ->addFilter(
                        (new FilterConfig)
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    ),
                /*(new FieldConfig)
                    ->setLabel('Estado Civil')
                    ->setName('estado_civil')
                    ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions($estado)
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()->where('estado_civil', '=', $val);
                            })
                    )
                ,*/
                (new FieldConfig)
                ->setName('fecha_ingreso')
                ->setLabel('Ingreso')
                ->setSortable(true),
                (new FieldConfig)
                ->setName('cargo')
                ->setLabel('Cargo')
                ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions($cargos)
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()->where('cargo_id', '=', $val);
                            })
                    )
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
                                    ->setRenderSection('filters_row_column_fecha_ingreso'),
                                (new DateRangePicker)
                                    ->setName('fecha_ingreso')
                                    ->setRenderSection('filters_row_column_fecha_ingreso')
                                    ->setDefaultValue(['1990-01-01', date('Y-m-d')])
                            ])
                        ,
                        (new OneCellRow)
                            ->setRenderSection(RenderableRegistry::SECTION_BEGIN)
                            ->setComponents([
                                (new RecordsPerPage)
                                    ->setVariants([
                                        10,
                                        15,
                                        20,
                                        30,
                                        40,
                                        50
                                    ]),
                                new ExcelExport(),
                                (new HtmlTag)
                                    ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filtrar')
                                    ->setTagName('button')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-success btn-sm'
                                    ])
                            ])
                    ])
                ,
                (new TFoot)
                    ->addComponents([
                        new Pager,
                        (new HtmlTag)
                            ->setAttributes(['class' => 'pull-right'])
                            ->addComponent(new ShowingRecords)
                    ])
            ])->setPageSize(10);

        $grid = new Grid($cfg);
        $text = "<h1>Constructing grid programmatically</h1>";
        return view('grid', compact('grid', 'text'));

    }

    public function form()
    {
        $enum = EnumCategories::where('category_id','=',9)->get()->load('categoria');
        $licencias = array();

        foreach($enum as $row){
            $licencias[$row->enum_value_id] = $row->categoria->name;
        }

        dd($licencias);

        /*$form = DataForm::source(EnumTables::find(1));
        $form->add('name','Enum Name', 'text')->rule('required|min:5');
        $form->add('type','Type','text')->rule('required|min:5');

        return view('form',compact('form'));*/
    }
}
