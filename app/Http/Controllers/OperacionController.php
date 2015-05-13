<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeader;
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
use SSOLeica\Core\Model\Operacion;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;
use SSOLeica\Core\Repository\OperacionRepository;

use Illuminate\Http\Request;
use Zofe\Rapyd\DataForm\DataForm;

class OperacionController extends Controller {

    /**
     * @var OperacionRepository
     */
    private $operacion_repository;

    public function __construct(OperacionRepository $operacion_repository)
    {
        $this->middleware('workspace');
        $this->operacion_repository = $operacion_repository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $query = $this->operacion_repository->getOperaciones(Session::get('pais_id'));

        $cfg = (new GridConfig())
            ->setName('gridOperaciones')
            ->setDataProvider(
                new EloquentDataProvider($query)
            )
            ->setColumns([
                (new IdFieldConfig)
                    ->setLabel('#'),
                (new FieldConfig)
                    ->setName('nombre_operacion')
                    ->setLabel('Proyecto')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    ),
                (new FieldConfig)
                    ->setName('ubicacion')
                    ->setLabel('Ubicación')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setOperator(FilterConfig::OPERATOR_LIKE)
                    ),
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val) {

                        $icon_edit = "<a href='/operacion/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Proyecto'><span class='glyphicon glyphicon-pencil'></span></a>";
                        $icon_remove = "<a href='/operacion/delete/$val' data-toggle='tooltip' data-placement='left' title='Eliminar Proyecto' ><span class='glyphicon glyphicon-trash'></span></a>";

                        return $icon_edit . ' ' . $icon_remove;
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
                                    ->setContent('<span class="glyphicon glyphicon-plus"></span> Registrar Nuevo Proyecto')
                                    ->setTagName('a')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-warning btn-sm',
                                        'href' => '/operacion/create'
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

        $text = "<h3>Información de Proyectos</h3>";

        return view('operacion.index', compact('grid', 'text'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function anyCreate()
	{
		$form = DataForm::source(new Operacion);

        $form->add('pais_id', '', 'hidden')->insertValue(Session::get('pais_id'));
        $form->add('nombre_operacion','Nombre Proyecto', 'text')->rule('required|min:4');
        $form->add('ubicacion','Ubicación', 'text');
        $form->add('descripcion','Descripción', 'redactor');

        $form->submit('Guardar');
        $form->link("/operacion","Cancelar");

        $form->saved(function () use ($form) {

            return new RedirectResponse(url('operacion/edit/'.$form->model->id));
        });

        return $form->view('operacion.create', compact('form'));
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
	public function anyEdit($id)
	{
        $form = DataForm::source($this->operacion_repository->find($id));

        $form->add('pais_id', '', 'hidden')->insertValue(Session::get('pais_id'));
        $form->add('nombre_operacion','Nombre Proyecto', 'text')->rule('required|min:4');
        $form->add('ubicacion','Ubicación', 'text');
        $form->add('descripcion','Descripción', 'redactor');

        $form->submit('Guardar');
        $form->link("/operacion","Cancelar");

        $form->saved(function () use ($form) {

            return new RedirectResponse(url('operacion/edit/'.$form->model->id));
        });

        return $form->view('operacion.edit', compact('form'));
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
