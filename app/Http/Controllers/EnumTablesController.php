<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Nayjest\Grids\SelectFilterConfig;
use SSOLeica\Core\Model\EnumTables;
use SSOLeica\Core\Repository\EnumTablesRepository;
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
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Zofe\Rapyd\DataForm\DataForm;

class EnumTablesController extends Controller {

    private $pais;
    private $timezone;
    /**
     * @var EnumTablesRepository
     */
    private $enumTablesRepository;

    /**
     * @param EnumTablesRepository $enumTablesRepository
     */
    public function __construct(EnumTablesRepository $enumTablesRepository)
    {
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->pais = Session::get('pais_id');
        $this->timezone = Session::get('timezone');

        $this->enumTablesRepository = $enumTablesRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$query = $this->enumTablesRepository->getModel()->query();

        $cfg = (new GridConfig())
            ->setName('gridEnums')
            ->setDataProvider(
                new EloquentDataProvider($query)
            )
            ->setColumns([
                (new IdFieldConfig)
                    ->setLabel('#'),
                (new FieldConfig)
                    ->setName('type')
                    ->setLabel('Type')
                    ->setSortable(true)
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions($this->enumTablesRepository->getTypes()->lists('type','type'))
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where('type','=',$val);
                            })
                    )->setSorting('ASC'),
                (new FieldConfig)
                    ->setName('name')
                    ->setLabel('Name')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(name)'), 'like', '%' . strtoupper($val) . '%');
                            })
                    ),
               /* (new FieldConfig)
                    ->setName('symbol')
                    ->setLabel('Symbol')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(symbol)'), 'like', '%' . strtoupper($val) . '%');
                            })
                    )
                ,*/
                (new FieldConfig)
                    ->setName('data')
                    ->setLabel('Attributes')
                    ->setCallback(function ($val) {

                      $data = "";



                        if(!is_null($val))
                        {
                            $json = json_decode($val);

                            $data = implode(',',$json);
                        }

                        return $data;
                    })
                ,
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val) {

                        $icon_edit = "<a href='/enums/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Enum'><span class='fa fa-edit'></span></a>";
                        $icon_remove = "<a href='/enums/delete/$val' data-toggle='tooltip' data-placement='left' title='Eliminar Enum' onclick='return confirm(\"Desea eliminar el Enum?\");' ><span class='glyphicon glyphicon-trash'></span></a>";

                        return  $icon_edit . ' ' . $icon_remove;
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
                                    ->setContent('<span class="glyphicon glyphicon-plus"></span> Registrar Nuevo Enum')
                                    ->setTagName('a')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-warning btn-sm',
                                        'href' => '/enums/create'
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

        $text = "<h3>Enums</h3>";

        return view('enums.index', compact('grid', 'text'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function anyCreate()
	{
        $form = DataForm::source(new EnumTables);

        $form->addSelect('type','Type')
            ->option('','[-- Seleccione --]')
            ->options($this->enumTablesRepository->getTypes()->lists('type','type'))
            ->rule('required')
            ->attr('data-live-search','true');;
        $form->addText('name', 'Nombre')->rule('required');
        $form->addText('symbol','Símbolo');
        $form->addText('DataString','Atributos');

        $form->submit('Guardar');
        $form->link("/enums","Cancelar");

        $form->saved(function () use ($form) {

            Session::flash('message', 'La información del Enum se Registró Correctamente');
            return new RedirectResponse(url('/enums/edit/'.$form->model->id));
        });

        $form->build();

        return $form->view('enums.create', compact('form'));
	}

    public function anyEdit($id = 0)
    {
        if($id == 0)
            return new RedirectResponse(url('/enums'));

        $enum = $this->enumTablesRepository->find($id);

        if(is_null($enum))
        {
            return new RedirectResponse(url('/enum'));
        }

        $form = DataForm::source($enum);

        $form->addHidden('type','Type')->rule('required');
        $form->addText('TypeLabel','Type')->attr('disabled','disabled');
        $form->addText('name', 'Nombre')->rule('required');
        $form->addText('symbol','Símbolo');
        $form->addText('DataString','Atributos');

        $form->submit('Guardar');
        $form->link("/enums","Cancelar");

        $form->saved(function () use ($form) {

            Session::flash('message', 'La información del Enum se Registró Correctamente');

            return new RedirectResponse(url('/enums/edit/'.$form->model->id));

        });

        $form->build();

        return $form->view('enums.edit', compact('form'));
    }

    public function getDelete($id=0)
    {
        if($id == 0)
            return new RedirectResponse(url('/enums'));

        //$enum = $this->enumTablesRepository->find($id);

        //if(is_null($enum))
            //return new RedirectResponse(url('/enum'));

        $this->enumTablesRepository->delete($id);

        Session::flash('message', 'El Enum fue eliminado Correctamente');

        return new RedirectResponse(url('/enums/index'));
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
