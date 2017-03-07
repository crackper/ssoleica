<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Model\Configurations;
use SSOLeica\Core\Repository\ConfigurationsRepository;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;

//grid
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
use Zofe\Rapyd\DataForm\DataForm;

class ConfigurationsController extends Controller {

    /**
     * @var ConfigurationsRepository
     */
    private $configurationsRepository;

    /**
     * @param ConfigurationsRepository $configurationsRepository
     */
    public  function __construct(ConfigurationsRepository $configurationsRepository)
    {
        $this->middleware('auth');
        $this->configurationsRepository = $configurationsRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$query = $this->configurationsRepository->getModel()->query();

        $cfg = (new GridConfig('configurations'));
        $cfg->setDataProvider( new EloquentDataProvider($query));

        $cfg->addColumn((new IdFieldConfig)->setLabel('#'));

        $cfg->addColumn((new FieldConfig)->setName("module")->setLabel("Modulo")->setSortable(true)
            ->addFilter(
                (new FilterConfig)->setFilteringFunc(function($val, EloquentDataProvider $provider){
                    $provider->getBuilder()->where(DB::raw('upper(module)'), 'like', '%' . strtoupper($val) . '%');
                })));

        $cfg->addColumn((new FieldConfig)->setName("application")->setLabel("Aplicación")->setSortable(true)
            ->addFilter(
                (new FilterConfig)
                    ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                        $provider->getBuilder()->where(DB::raw('upper(application)'), 'like', '%' . strtoupper($val) . '%');
                    })));

        $cfg->addColumn((new FieldConfig)->setName("attribute")->setLabel("Atributo")->setSortable(true)
            ->addFilter(
                (new FilterConfig)
                    ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                        $provider->getBuilder()->where(DB::raw('upper(attribute)'), 'like', '%' . strtoupper($val) . '%');
                    })));

        $cfg->addColumn((new FieldConfig)->setName("value")->setLabel("Valor")->setSortable(true)
            ->addFilter(
                (new FilterConfig)
                    ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                        $provider->getBuilder()->where(DB::raw('upper(value)'), 'like', '%' . strtoupper($val) . '%');
                    }))
            ->setCallback(function($val){


                return  substr(trim($val),0,80).'...</p>';
            }));

        $cfg->addColumn((new FieldConfig)->setName('updated_at')->setLabel("Actualizado")->setSortable(true));


        $cfg->addColumn((new FieldConfig)->setName("id")->setLabel("Acciones")->setSortable(true)
            ->setCallback(function($val){

                $icon_edit = "<a href='/configurations/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Configuración'><span class='fa fa-edit'></span></a>";
                $icon_remove = "<a href='/configurations/delete/$val' data-toggle='tooltip' data-placement='left' title='Eliminar Configuración' ><span class='glyphicon glyphicon-trash'></span></a>";

                return  $icon_edit . ' ' . $icon_remove;
            }));


        $one_cell = (new OneCellRow)
            ->setRenderSection(RenderableRegistry::SECTION_BEGIN)
            ->setComponents([
                (new RecordsPerPage)
                    ->setVariants([5,10,15,20,30,40,50]),
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
                    ->setContent('<span class="glyphicon glyphicon-plus"></span> Registrar Configuración')
                    ->setTagName('a')
                    ->setRenderSection(RenderableRegistry::SECTION_END)
                    ->setAttributes([
                        'class' => 'btn btn-warning btn-sm',
                        'href' => '/configurations/create'
                    ])
            ]);

        $cfg->setComponents([(new THead)->setComponents([new ColumnHeadersRow,new FiltersRow,$one_cell]),
            (new TFoot)->addComponents([new Pager,(new HtmlTag)->setAttributes(['class' => 'pull-right'])->addComponent(new ShowingRecords)])
        ]);

        $cfg->setPageSize(10);

        $grid = new Grid($cfg);

        $text = "<h3>Configuraciones</h3>";

        return view('configurations.index', compact('grid', 'text'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function anyCreate()
	{
		$form = DataForm::source(new Configurations);

        $form->add("module","Modulo","text")->rule('required|min:5');
        $form->add("application","Aplicación","text")->rule('required|min:3');
        $form->add("attribute","Atributo","text")->rule('required|min:1');
        $form->add("value","Valor","textarea")->rule('required|min:1');

        $form->submit('Guardar');
        $form->link("/configurations","Cancelar");

        $form->saved(function () use ($form) {

            Session::flash('message', 'La información de la Configuración se Registró Correctamente');
            return new RedirectResponse(url('configurations/edit/'.$form->model->id));
        });

        $form->build();

        return $form->view('configurations.create', compact('form'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function anyEdit($id = 0)
	{
		if($id==0)
            return new RedirectResponse(url('/configurations'));

        $config = $this->configurationsRepository->find($id);

        if(is_null($config))
            return new RedirectResponse(url('/configurations'));

        $form = DataForm::source($config);

        $form->add("module","Modulo","text")->rule('required|min:5');
        $form->add("application","Aplicación","text")->rule('required|min:3');
        $form->add("attribute","Atributo","text")->rule('required|min:1');
        $form->add("value","Valor","textarea")->rule('required|min:1');

        $form->submit('Guardar');
        $form->link("/configurations","Cancelar");

        $form->saved(function () use ($form) {

            Session::flash('message', 'La información de la Configuración se Registró Correctamente');
            return new RedirectResponse(url('configurations/edit/'.$form->model->id));
        });

        $form->build();

        return $form->view('configurations.edit', compact('form'));

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
