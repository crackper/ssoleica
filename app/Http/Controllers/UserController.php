<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 17/07/15
 * Time: 8:26 AM
 */

namespace SSOLeica\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Model\Trabajador;
use Validator;
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
use SSOLeica\Core\Model\EnumTables;
use SSOLeica\Core\Model\Role;
use SSOLeica\Core\Model\User;
use SSOLeica\Core\Repository\EnumTablesRepository;
use Illuminate\Http\Request;


class UserController extends Controller {

    /**
     * @var enumTablesRepository
     */
    private $enumTablesRepository;

    /**
     * @param EnumTablesRepository $enumTablesRepository
     */
    public function __construct(EnumTablesRepository $enumTablesRepository)
    {
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->beforeFilter('access_usuarios', array('only' => 'index') );
        $this->enumTablesRepository = $enumTablesRepository;
    }

    public function getIndex()
    {
        $query = (new User)->query();

        foreach($query as $user){
            $user['rol'] = $user->roles()->first();
        }

        //dd($query->get());

        $cfg = (new GridConfig())
            ->setName('gridUsuarios')
            ->setDataProvider(
                new EloquentDataProvider($query)
            )
            ->setColumns([
                (new IdFieldConfig)->setLabel('#'),
                (new FieldConfig)
                    ->setName('name')
                    ->setLabel('Usuario')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)->setOperator(FilterConfig::OPERATOR_LIKE)
                    ),
                (new FieldConfig)
                    ->setName('email')
                    ->setLabel('E-mail')
                    ->setSortable(true)
                    ->addFilter(
                        (new FilterConfig)->setOperator(FilterConfig::OPERATOR_LIKE)
                    ),
                (new FieldConfig)
                    ->setName('active')
                    ->setLabel('Activo')
                    ->setSortable(true)
                    ->setCallback(function($val){
                        return $val == 1 ? "<div class='text-center'><span class='glyphicon glyphicon-ok'></span></div>":"<div class='text-center'><span class='glyphicon glyphicon-remove'></span></div>";
                    })
                    ->addFilter(
                        (new SelectFilterConfig)
                            ->setSubmittedOnChange(true)
                            ->setOptions(array('0'=>'No','1' => 'Si' ))
                            ->setFilteringFunc(function($val, EloquentDataProvider $provider){
                                $provider->getBuilder()->where('active','=',$val);
                            })
                    ),
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Roles')
                    ->setCallback(function ($val,EloquentDataRow $row) {

                        $user = $row->getSrc();

                        $var ='';

                        foreach ($user->roles()->get() as $rol)
                        {
                            $var .=' <span class="label label-warning">'.$rol->display_name.'</span>';
                        }

                        return $var;
                    }),
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val) {

                        $icon_edit = "<a href='/user/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Usuario'><span class='glyphicon glyphicon-pencil'></span></a>";
                        $icon_remove = "<a href='/user/delete/$val' data-toggle='tooltip' data-placement='left' title='Eliminar Usuario' ><span class='glyphicon glyphicon-trash'></span></a>";

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
                                    ->setContent('<span class="glyphicon glyphicon-plus"></span> Registrar Nuevo Usuario')
                                    ->setTagName('a')
                                    ->setRenderSection(RenderableRegistry::SECTION_END)
                                    ->setAttributes([
                                        'class' => 'btn btn-warning btn-sm',
                                        'href' => '/user/create',
                                        'data-perm' => Auth::user()->hasRole('admin') == 1 ? 1 : 0
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
            ->setPageSize(10);

        $grid = new Grid($cfg);

        $text = "<h3>Información de Usuarios</h3>";

        return view('user.index', compact('grid', 'text'));
    }


    public function getCreate()
    {
        $text = 'Registrar Usuario';

        $roles = Role::all()->lists('display_name','id');

        $paises = array('' => '[-- Seleccione un Pais --]') + $this->enumTablesRepository->getPaises()->lists('name','id');



        return view('user.create')
            ->with('text',$text)
            ->with('roles',$roles)
            ->with('paises',$paises);
    }

    public function postCreate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'pais_id' => 'required',
            'trabajador_id' => 'required'
        ]);


        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $user = $request->only('name','email','password','pais_id','active','trabajador_id');
        $user['active'] = $request->has('active') ? true : false;
        $user['password'] = Hash::make($user['password']);


        $new_user = User::create($user);


        if($request->has('roles'))
        {
            foreach($request->get('roles') as $rol)
            {
                $new_user->attachRole(Role::find($rol));
            }
        }


        Session::flash('message', 'El Usuario se registro Correctamente');

        return new RedirectResponse(url('/user/index'));
    }

    public function getTrabajadores($key = '')
    {
        $query = Trabajador::where(DB::raw("upper(nombre) like '%'|| upper('".$key."') || '%' or upper(app_paterno) like '%'|| upper('".$key."') || '%'"))
                ->orderBy('nombre', 'asc')
                ->skip(0)->take(10)->get();

        $data = array();
        foreach($query as $trabajador)
        {
            $data[] = array('id' => $trabajador->id, 'name' =>  $trabajador->nombre .' '. $trabajador->app_paterno, 'email' => $trabajador->email );
        }

        return Response::json($data);
    }

    public function getEdit($id)
    {
        $text = 'Registrar Usuario';

        $user = User::find($id);

        $in_rol=array();

        $roles = Role::all();

        foreach($roles as $rol)
        {
            $in_rol[] = (object)array('id' =>$rol->id, 'name'=>$rol->display_name, 'to_user'=> $user->hasRole($rol->name));
        }


        $paises = array('' => '[-- Seleccione un Pais --]') + $this->enumTablesRepository->getPaises()->lists('name','id');

        return view('user.edit')
            ->with('text',$text)
            ->with('user',$user)
            ->with('roles',$in_rol)
            ->with('paises',$paises);
    }

    public function postUpdate($id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'roles' => 'required',
            'pais_id' => 'required',
        ]);


        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $user = User::find($id);

        $user->name = $request->get('name');
        $user->pais_id = $request->get('pais_id');
        $user->active = $request->has('active');

        if($request->password != '')
            $user->password =   Hash::make($request->get('password'));

        $user->save();

        if($request->has('roles'))
        {
            $user->roles()->detach();

            foreach($request->get('roles') as $rol)
            {
                $user->attachRole(Role::find($rol));
            }
        }

        dd($user);

    }

    public function getDelete($id)
    {
        if($id == 1)
        {
            Session::flash('message', 'Este usuario no puede ser eliminado');

            return new RedirectResponse(url('/user/index'));
        }

        $user = User::find($id);

        $user->delete();

        Session::flash('message', 'El Usuario fue eliminado Correctamente');

        return new RedirectResponse(url('/user/index'));
    }

}