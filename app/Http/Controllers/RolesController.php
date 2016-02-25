<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use SSOLeica\Core\Model\Role;
use SSOLeica\Core\Repository\PermissionRepository;
use SSOLeica\Core\Repository\RolesRepository;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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

class RolesController extends Controller {

    private $pais;
    private $timezone;
    /**
     * @var RolesRepository
     */
    private $rolesRepository;
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * @param RolesRepository $rolesRepository
     */
    public function __construct(RolesRepository $rolesRepository,PermissionRepository $permissionRepository)
    {
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->pais = Session::get('pais_id');
        $this->timezone = Session::get('timezone');
        $this->rolesRepository = $rolesRepository;
        $this->permissionRepository = $permissionRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $query = $this->rolesRepository->getModel()->query();

        $btn_crear = (new HtmlTag)->setContent("")->setTagName('div')->setRenderSection(RenderableRegistry::SECTION_END); /*(new HtmlTag)
            ->setContent('<span class="glyphicon glyphicon-plus"></span> Crear Nuevo Permiso')
            ->setTagName('a')
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setAttributes([
                'class' => 'btn btn-warning btn-sm',
                'href' => '/permisos/create'
            ]);*/

        $acciones = (new FieldConfig())->setName('id')->setLabel(" ")->setCallback(function ($val) {return "";});

        $cfg = (new GridConfig())
            ->setName('gridPermisos')
            ->setDataProvider(
                new EloquentDataProvider($query)
            )
            ->setColumns([
                (new IdFieldConfig)
                    ->setLabel('#'),
                (new FieldConfig)
                    ->setName('name')
                    ->setLabel('Role')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(name)'), 'like', '%' . strtoupper($val) . '%');
                            })
                    ),
                (new FieldConfig)
                    ->setName('display_name')
                    ->setLabel('Nombre')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where(DB::raw('upper(display_name)'), 'like', '%' . strtoupper($val) . '%');
                            })
                    ),
                (new FieldConfig)
                    ->setName('permisos')
                    ->setLabel('Permisos')
                    ->setCallback(function($val){

                        $data = implode(',',$val->lists('display_name'));

                        $var ='';

                        foreach (explode(',',$data) as $k=>$v)
                        {
                            $var .=' <span class="label label-primary">'.$v.'</span>';
                        }


                        return $var;
                    }),
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val) {

                        $icon_edit = "<a href='/roles/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Rol'><span class='fa fa-edit'></span>Editar</a>";

                        return  $icon_edit;
                    }),$acciones

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
                                    ->setContent('<span class="glyphicon glyphicon-plus"></span> Crear Nuevo Permiso')
                                    ->setTagName('a')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-warning btn-sm',
                                        'href' => '/roles/create'
                                    ]),
                                $btn_crear
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

        $text = "<h3>Roles</h3>";

        return view('roles.index', compact('grid', 'text'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function anyCreate()
    {
        $permisos = $this->permissionRepository->getModel()->lists('display_name','id');

        $form = DataForm::source(new Role);
        $form->addText('name','Role')->rule('required');
        $form->addText('display_name','Nombre')->rule('required');
        $form->add('permisos','Permisos','checkboxgroup')->options($permisos);
        $form->addTextarea('description','Descripcion');

        $form->submit('Guardar');
        $form->link("/roles","Cancelar");

        $form->saved(function () use ($form) {

            Session::flash('message', 'La información del Rol se Registró Correctamente');
            return new RedirectResponse(url('/roles/edit/'.$form->model->id));
        });

        $form->build();

        return $form->view('roles.create', compact('form'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function anyEdit($id = 0)
	{

        if($id == 0)
            return new RedirectResponse(url('/roles'));

        $rol = $this->rolesRepository->find($id);

        if(is_null($rol))
            return new RedirectResponse(url('/roles'));

        $permisos = $this->permissionRepository->getModel()->lists('display_name','id');

        $form = DataForm::source($rol);
        $form->addText('name','Role')->rule('required');
        $form->addText('display_name','Nombre')->rule('required');
        $form->add('permisos','Permisos','checkboxgroup')->options($permisos);
        $form->addTextarea('description','Descripcion');

        $form->submit('Guardar');
        $form->link("/roles","Cancelar");

        $form->saved(function () use ($form) {

            Session::flash('message', 'La información del Rol se Registró Correctamente');
            return new RedirectResponse(url('/roles/edit/'.$form->model->id));
        });

        $form->build();

        return $form->view('roles.edit', compact('form'));
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
