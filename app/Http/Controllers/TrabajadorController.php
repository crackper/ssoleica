<?php namespace SSOLeica\Http\Controllers;

use Nayjest\Grids\Components\ColumnHeader;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use SSOLeica\Core\Repository\TrabajadorRepository as Trabajador;
use SSOLeica\Core\Repository\EnumTablesRepository as EnumTables;
use Grids;
use HTML;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\SelectFilterConfig;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
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
use Nayjest\Grids\Components\ColumnsHider;



class TrabajadorController extends Controller {
    /**
     * @var Trabajador
     */
    private $trabajador;
    /**
     * @var EnumTables
     */
    private $enum_tables;

    /**
     * @param Trabajador $trabajador
     * @param EnumTables $enum_tables
     */
    public  function __construct(Trabajador $trabajador, EnumTables $enum_tables){

        $this->trabajador = $trabajador;
        $this->enum_tables = $enum_tables;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $query = $this->trabajador->getTrabajadores();

        $cargos = array();

        foreach($this->enum_tables->getCargos() as $row)
        {
            $cargos[$row->id] = $row->name;
        }

        $cfg = (new  GridConfig())
            ->setName("gridTrabadores")
            ->setDataProvider(
                new EloquentDataProvider($query)
            )
            ->setColumns([
                (new IdFieldConfig)
                    ->setLabel('#'),
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
                    ),
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val) {

                        $icon_edit = "<a href='/trabajador/$val/edit' data-toggle='tooltip' data-placement='left' title='Editar Trabajador'><span class='glyphicon glyphicon-pencil'></span></a>";
                        $icon_remove = "<a href='/trabajador/$val/delete' data-toggle='tooltip' data-placement='left' title='Eliminar Trabajador' ><span class='glyphicon glyphicon-trash'></span></a>";

                        return $icon_edit.' '.$icon_remove;
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
                                new ColumnsHider,
                                new ExcelExport(),
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
                                    ->setContent('<span class="glyphicon glyphicon-plus"></span> Registrar Nuevo Trabajador')
                                    ->setTagName('a')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-warning btn-sm',
                                        'href' => '/trabajador/create'
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

        $text = "<h3>Información Trabajadores</h3>";

        return view('trabajador.index', compact('grid', 'text'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		dd('create trabajador');
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
		dd($id);
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

    /**
     * @param $id
     */
    public function delete($id)
    {
        dd($id);
    }

}
