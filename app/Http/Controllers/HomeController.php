<?php namespace SSOLeica\Http\Controllers;

use Carbon\Carbon;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use SSOLeica\Core\Model\EnumTables;
use SSOLeica\Core\Model\TrabajadorOperacion;
use SSOLeica\Core\Model\EnumCategories;
use SSOLeica\Core\Repository\OperacionRepository;
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
use Illuminate\Support\Facades\Session;
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
     * @var OperacionRepository
     */
    private $operacionRepository;

    private $pais;
    private $timezone;

    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Trabajador $trabajador,OperacionRepository $operacionRepository)
	{
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->trabajador = $trabajador;
        $this->operacionRepository = $operacionRepository;
        $this->pais = Session::get('pais_id');
        $this->timezone = Session::get('timezone');
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

    public function help($seccion=null)
    {
        switch($seccion)
        {
            case "introduccion":

                $text = "<h1>Introdución</h1>";
                $breadcrumb = "Introdución";

                return view('help.introduccion')
                    ->with('text',$text)
                    ->with('breadcrumb',$breadcrumb);

                break;

            case "repository":

                $text = "<h1>Repositorio</h1>";
                $breadcrumb = "Repositorio";

                return view('help.repository')
                    ->with('text',$text)
                    ->with('breadcrumb',$breadcrumb);

                break;

            case "proyectos":

                $text = "<h1>Proyectos y Contratos</h1>";
                $breadcrumb = "Proyectos y Contratos";

                return view('help.proyectos')
                    ->with('text',$text)
                    ->with('breadcrumb',$breadcrumb);

                break;

            case "admin-trabajadores":

                $text = "<h1>Admin. Trabajadores</h1>";
                $breadcrumb = "Admin. Trabajadores";

                return view('help.admin_trabajadores')
                    ->with('text',$text)
                    ->with('breadcrumb',$breadcrumb);

                break;

            case "admin-trabajador-proyecto":

                $text = "<h1>Trabajador Asignar Proyecto</h1>";
                $breadcrumb = "Trabajador Asignar Proyecto";

                return view('help.admin_trabajador_proyecto')
                    ->with('text',$text)
                    ->with('breadcrumb',$breadcrumb);

                break;

            default:

                $text = "<h1>Ayuda</h1>";
                $breadcrumb = "";

                return view('help.index')
                    ->with('text',$text)
                    ->with('breadcrumb',$breadcrumb);

                break;
        }

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

        $proyectos = $this->operacionRepository->getOperaciones($this->pais)->get();

        $data_f = array();
        $data_e = array();
        $data_d = array();

        foreach($proyectos as $key=>$row)
        {
            //fotochecks
            $query_f = "select p.name as  pais,o.nombre_operacion as operacion, (t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
            $query_f .= "tc.nro_fotocheck as fotocheck, ";
            $query_f .= "tc.fecha_vencimiento at time zone 'utc' at time zone (p.data->>0)::text as fecha_vencimiento ";
            $query_f .= "from trabajador_contrato tc ";
            $query_f .= "inner join trabajador t on tc.trabajador_id = t.id ";
            $query_f .= "inner join contrato c on tc.contrato_id = c.id ";
            $query_f .= "inner join operacion o on c.operacion_id = o.id ";
            $query_f .= "inner join enum_tables p on o.pais_id = p.id ";
            $query_f .= "where (tc.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month')) ";
            $query_f .= "and p.id = :pais_id and operacion_id = :operacion_id order by tc.fecha_vencimiento";

            $fotochecks = DB::select(DB::Raw($query_f),array('pais_id' => $this->pais,'operacion_id'=>$row->id));

            if(count($fotochecks)>0)
            {
                $proyecto["proyecto"] = $row->nombre_operacion;
                $proyecto["fotochecks"]= $fotochecks;
                $data_f[]=$proyecto;
            }
        }



        foreach($proyectos as $key=>$row)
        {
            //examenes
            $query_e = "select p.name as  pais,o.nombre_operacion as operacion,v.type, ";
            $query_e .= "(t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
            $query_e .= "v.name as vencimiento, ";
            $query_e .= "tv.fecha_vencimiento at time zone 'utc' at time zone (p.data->>0)::text as fecha_vencimiento ";
            $query_e .= "from trabajador_vencimiento tv ";
            $query_e .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
            $query_e .= "inner join trabajador t on tv.trabajador_id = t.id ";
            $query_e .= "inner join operacion o on tv.operacion_id = o.id ";
            $query_e .= "inner join enum_tables p on o.pais_id = p.id ";
            $query_e .= "where tv.caduca = true and v.type = 'ExamenMedico' ";
            $query_e .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month')) ";
            $query_e .= "and p.id = :pais_id and o.id = :operacion_id ";
            $query_e .= "order by o.nombre_operacion,tv.fecha_vencimiento,t.app_paterno";

            $examenes = DB::select(DB::Raw($query_e),array('pais_id' => $this->pais,'operacion_id'=>$row->id));

            if(count($examenes)>0)
            {
                $proyecto_e["proyecto"] = $row->nombre_operacion;
                $proyecto_e["examenes"]= $examenes;
                $data_e[]=$proyecto_e;
            }
        }


        //documentos
        $query_d = "select p.name as  pais,v.type, ";
        $query_d .= "(t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
        $query_d .= "v.name as vencimiento, ";
        $query_d .= "tv.fecha_vencimiento at time zone 'utc' at time zone (p.data->>0)::text as fecha_vencimiento ";
        $query_d .= "from trabajador_vencimiento tv ";
        $query_d .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
        $query_d .= "inner join trabajador t on tv.trabajador_id = t.id ";
        $query_d .= "inner join enum_tables p on t.pais_id = p.id ";
        $query_d .= "where tv.caduca = true and v.type = 'Documento' ";
        $query_d .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month')) ";
        $query_d .= "and p.id = :pais_id ";
        $query_d .= "order by tv.fecha_vencimiento,t.app_paterno ";

        $documentos = DB::select(DB::Raw($query_d),array('pais_id' => $this->pais));

        if(count($documentos) > 0)
        {
            $proyecto_d["proyecto"] = "Otros Documentos";
            $proyecto_d["documentos"]= $documentos;
            $data_d[]=$proyecto_d;
        }

        /*return view('alertas.index')
            ->with('data_f',$data_f)
            ->with('data_e',$data_e)
            ->with('data_d',$data_d);*/


        return view("emails.alertas")
            ->with('pais','Perú')
            ->with('subject','Samuel')
            ->with('data_f',$data_f)
            ->with('data_e',$data_e)
            ->with('data_d',$data_d);

        /*$years = array('39'=>'2015','40'=>'2016','41'=>'2017','42'=>'2018','43'=>'2019','44'=>'2020');
        $months = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $fechas = array();

        foreach( $years as $id => $year)
        {
            foreach($months as $key => $value){

                $d = 1;
                $m = $key + 1;
                $Y = $year;
                $primerDia = gmdate("d-m-Y H:i:s", mktime(0, 0, 0,$m, $d-$d +1,$Y));
                $ultimoDia = gmdate("d-m-Y H:i:s", mktime(11, 59, 59,$m+1,$d-$d,$Y));

                $fechas[] = $primerDia;
                $fechas[] = $ultimoDia;

            }
        }*/


        /*$fecha= Carbon::now();

        $fecha= strtotime($fecha); //Recibimos la fecha y la convertimos a tipo fecha
        $d = date("d",$fecha); //Obtenemos el dia
        $m = date("m",$fecha); //Obtenemos el mes
        $Y = date("Y",$fecha); //Obtenemos el año
        $primerDia = date("d-m-Y H:i:s", mktime(0, 0, 0,$m, $d-$d +1,$Y));
        $ultimoDia = date("d-m-Y H:i:s", mktime(11, 59, 59,$m+1,$d-$d,$Y));*/

        dd($fechas);

        /*$enum = EnumCategories::where('category_id','=',9)->get()->load('categoria');
        $licencias = array();

        foreach($enum as $row){
            $licencias[$row->enum_value_id] = $row->categoria->name;
        }

        dd($licencias);*/

        /*$form = DataForm::source(EnumTables::find(1));
        $form->add('name','Enum Name', 'text')->rule('required|min:5');
        $form->add('type','Type','text')->rule('required|min:5');

        return view('form',compact('form'));*/
    }

    public function fechas(){

        $fecha= Carbon::now();

        $fecha= strtotime($fecha); //Recibimos la fecha y la convertimos a tipo fecha
        $d = date("d",$fecha); //Obtenemos el dia
        $m = date("m",$fecha); //Obtenemos el mes
        $Y = date("Y",$fecha); //Obtenemos el año
        $primerDia = date("d-m-Y", mktime(0, 0, 0,$m, $d-$d +1,$Y));

        dd($primerDia);
    }

}
