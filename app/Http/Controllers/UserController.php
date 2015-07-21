<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 17/07/15
 * Time: 8:26 AM
 */

namespace SSOLeica\Http\Controllers;


use Illuminate\Support\Facades\Auth;

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
use SSOLeica\Core\Model\User;

class UserController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->beforeFilter('access_usuarios', array('only' => 'index') );
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
} 