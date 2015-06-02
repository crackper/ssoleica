<?php namespace SSOLeica\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Model\Contrato;
use SSOLeica\Core\Model\EnumCategories;
use SSOLeica\Core\Model\TrabajadorVencimiento;
use SSOLeica\Core\Repository\ContratoRepository;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Core\Repository\TrabajadorRepository;
use SSOLeica\Http\Requests;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use SSOLeica\Core\Repository\TrabajadorRepository as Trabajador;
use SSOLeica\Core\Repository\EnumTablesRepository;
use HTML;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\IdFieldConfig;
use Nayjest\Grids\SelectFilterConfig;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
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
use Zofe\Rapyd\DataForm\DataForm;


class TrabajadorController extends Controller
{
    /**
     * @var Trabajador
     */
    private $trabajador;
    /**
     * @var EnumTables
     */
    private $enum_tables;
    /**
     * @var Trabajador
     */
    private $trabajadorRepository;
    /**
     * @var ContratoRepository
     */
    private $contratoRepository;
    /**
     * @var OperacionRepository
     */
    private $operacionRepository;
    /**
     * @var EnumTablesRepository
     */
    private $enumTablesRepository;


    /**
     * @param Trabajador $trabajador
     * @param EnumTablesRepository $enumTablesRepository
     * @param Trabajador $trabajadorRepository
     * @param ContratoRepository $contratoRepository
     * @param OperacionRepository $operacionRepository
     * @internal param EnumTables $enum_tables
     */
    public function __construct(Trabajador $trabajador,
                                EnumTablesRepository $enumTablesRepository,
                                TrabajadorRepository $trabajadorRepository,
                                ContratoRepository $contratoRepository,
                                OperacionRepository $operacionRepository)
    {
        $this->middleware('workspace');

        $this->trabajador = $trabajador;
        $this->trabajadorRepository = $trabajadorRepository;
        $this->contratoRepository = $contratoRepository;
        $this->operacionRepository = $operacionRepository;
        $this->enumTablesRepository = $enumTablesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $query = $this->trabajador->getTrabajadores()->where('pais_id', '=', Session::get('pais_id'));
        //dd($query->get());
        $cargos = array();

        foreach ($this->enumTablesRepository->getCargos() as $row) {
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
                    ->setName('full_name')
                    ->setLabel('Trabajador')
                    ->setSortable(true)
                    ->setSorting(Grid::SORT_ASC)
                    ->setCallback(function ($val) {
                        return "<span class='glyphicon glyphicon-user'></span> {$val}";
                    })
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
                                    ->where('app_paterno', 'like', '%' . $val . '%')
                                    ->orWhere('app_materno', 'like', '%' . $val . '%')
                                    ->orWhere('nombre', 'like', '%' . $val . '%');
                            })
                    )
                ,
                (new FieldConfig)
                    ->setName('email')
                    ->setLabel('E-mail'),
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
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()->where('cargo_id', '=', $val);
                            })
                    ),
                (new FieldConfig())
                    ->setName('id')
                    ->setLabel('Acciones')
                    ->setCallback(function ($val) {

                        $icon_edit = "<a href='/trabajador/edit/$val' data-toggle='tooltip' data-placement='left' title='Editar Trabajador'><span class='glyphicon glyphicon-pencil'></span></a>";
                        $icon_remove = "<a href='/trabajador/$val/delete' data-toggle='tooltip' data-placement='left' title='Eliminar Trabajador' ><span class='glyphicon glyphicon-trash'></span></a>";

                        return $icon_edit . ' ' . $icon_remove;
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
                                //new ExcelExport(),
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

    public function getProyectos($id)
    {
        $data = $this->trabajadorRepository->getContratos($id);

        return view('trabajador.proyectos')->with('data', $data)->with('trabajador_id',$id);
    }

    /**
     * @param  int $id
     * @return Response
     */
    public function anyEdit($id)
    {
        $pais = $this->enumTablesRepository->find(Session::get('pais_id'))->load('categorias.categoria');

        $licencias = array();
        $licencias[] = "[- Seleccione -]";
        foreach ($pais->categorias as $row) {
            $licencias[$row->enum_value_id] = $row->categoria->name;
        }

        $edit = DataForm::source($this->trabajador->find($id));


        $edit->add('dni', 'DNI', 'text')->rule('required|min:8');
        $edit->add('nombre', 'Nombre', 'text')->rule('required|max:100');
        $edit->add('app_paterno', 'Apellido Paterno', 'text')->rule('required');
        $edit->add('app_materno', 'Apellido Materno', 'text')->rule('required');
        $edit->add('sexo', 'Sexo', 'radiogroup')->option('F', 'Femenino')->option('M', 'Masculino');
        $edit->add('fecha_nacimiento', 'Fecha de Nacimiento', 'date')->format('d/m/Y', 'it')->rule('required');
        $edit->add('estado_civil', 'Estado Civil', 'select')->options(array('Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo', 'Divorciado' => 'Divorciado', 'Conviviente' => 'Conviviente'));
        $edit->add('direccion', 'Direccion', 'text');
        $edit->add('email', 'E-mail', 'text')->rule('email');
        $edit->add('nro_telefono', 'Nro. Telefono', 'text');
        $edit->add('fecha_ingreso', 'Fecha de Ingreso', 'date')->format('d/m/Y', 'it')->rule('required');
        $edit->add('profesion_id', 'Profesion', 'select')->options($this->enumTablesRepository->getProfesiones()->lists('name', 'id'));
        $edit->add('cargo_id', 'Cargo', 'select')->options($this->enumTablesRepository->getCargos()->lists('name', 'id'));
        //informacion adicional
        $edit->add('foto', 'Foto', 'image')->move('uploads/images/')->preview(150, 200);
        $edit->add('grupo_saguineo', 'Grupo Sanquineo', 'select')->options(array('' => '[- Seleccione -]', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-'));
        $edit->add('lic_conducir', 'Licencia de Conducir', 'text');
        $edit->add('lic_categoria_id', 'Tipo Licencia', 'select')->options($licencias);
        $edit->add('em_nombres', 'Nombres', 'text');
        $edit->add('em_telef_fijo', 'Telefono Fijo', 'text');
        $edit->add('em_telef_celular', 'Telefono Celular', 'text');
        $edit->add('em_parentesco', 'Parentesco', 'select')->options(array('' => '[- Seleccione -]', 'Padre' => 'Padre', 'Madre' => 'Madre', 'Esposo(a)' => 'Esposo(a)', 'Hijo(a)' => 'Hijo(a)', 'Hermano(a)' => 'Hermano(a)', 'Otro' => 'Otro'));
        $edit->add('em_direccion', 'Dirección', 'text');

        $edit->submit('Guardar');
        $edit->link("/trabajador", "Cancelar");

        $edit->saved(function () use ($edit) {

            return new RedirectResponse(url('trabajador/edit/' . $edit->model->id));
            // $edit->message("ok record saved");
            //$edit->link("/trabajador","Next Step");

        });

        $edit->built();

        return $edit->view('trabajador.edit', compact('edit','id'));
    }

    /**
     * @return json
     */
    public function postUpdatefecha()
    {
        $contrato_id = Input::get('contrato');

        $changeContrato = array(
            'fecha_vencimiento' => Carbon::parse(Input::get('fecha'))->format('Y-m-d'),
            'observaciones' => Input::get('obs')
        );

        $success = $this->trabajadorRepository->updateContrato($contrato_id,$changeContrato);

        $data = $success == 1 ? "La fecha de vencimiento se actualizó satisfactoriamente." : "Error: No se pudo actualizar";

        return Response::json(array(
            'success' => $success,
            'data'   => $data
        ));
    }

    /**
     * @return response
     */
    public function postCambiarcontrato()
    {
        $data['proyecto']           =   Input::get('proyecto');
        $data['contrato']           =   Input::get('contrato');
        $data['proyectoId']         =   Input::get('proyectoId');
        $data['contratoId']         =   Input::get('contratoId');
        $data['contratoTrabajador'] =   Input::get('contratoTrabajador');

        $data['contratos'] = $this->contratoRepository->getContratosDisponibles($data['proyectoId'], $data['contratoId']);

        $data['existContratos'] = count($data['contratos']) > 0 ? true : false;
        
        return view('trabajador.cambiarContrato')->with('data',$data);
    }

    /**
     * @param $id
     * @return json
     */
    public function postSavecontratotrabajador($id)
    {
        $fechaFin = Input::get('fecFinActual');
        $data['fecha_inicio'] = Input::get('fecIniCambio');
        $data['contrato_id'] = Input::get('contrato_id');

        $success = $this->trabajadorRepository->updateContrato($id,$data,$fechaFin);

        $data = $success == 1 ? 'La información se actualizó correctamente' : "Error: No se puedo actualizar el contrato";

        return Response::json(array(
            'success' => $success,
            'data'   => $data
        ));
    }

    public function getAsignarcontrato($id)
    {
        $operaciones = $this->operacionRepository->getOperacionesDiponiblesByTrabajador($id);

        $query = array('' => '[-- Seleccione un proyecto--]') + $operaciones;

        $data['proyectos'] = $query;
        $data['trabajador_id'] = $id;

        return view('trabajador.asignarContrato')->with('data',$data);
    }

    public function postAsignarcontrato($id)
    {
        $data['trabajador_id'] = $id;
        $data['contrato_id'] = Input::get('contrato_id');
        $data['fecha_inicio'] = Input::get('fecInicio');
        $data['nro_fotocheck'] = Input::get('nroFotocheck');
        $data['fecha_vencimiento'] = Input::get('fecVencimiento');

        $success = $this-> contratoRepository->registarContratoTrabajador($data);

        $data = $success ? "La informacion de guardo correctamente." : "Error: No se pudo guardar la información";

        return Response::json(array(
            'success' => $success,
            'data'   => $data
        ));

    }

    //refactorizar
    public function getContratos($id = 0)
    {
        $query = Contrato::where('operacion_id','=',$id)->lists('nombre_contrato','id');
        return Response::json($query);
    }

    public function getProyectostrabajador($trabajador_id)
    {
        $data = $this->operacionRepository->getListsOperacionesByTrabajador($trabajador_id);

        return Response::json($data);
    }

    public  function getExamenesmedicos($trabajador_id, $operacion_id,$proyecto)
    {

        $query = TrabajadorVencimiento::join('enum_tables','enum_tables.id','=','trabajador_vencimiento.vencimiento_id')
                    ->where('trabajador_vencimiento.trabajador_id','=',$trabajador_id)
                    ->where('trabajador_vencimiento.operacion_id','=',$operacion_id)
                    ->where('enum_tables.type','=','ExamenMedico')
                    ->select('trabajador_vencimiento.*')
                    ->addSelect('enum_tables.name as examen_medico')
                    ->get();

        //dd($query);

        return view('trabajador.examenes')->with('data',$query)
            ->with('proyecto',$proyecto)
            ->with('trabajador_id',$trabajador_id)
            ->with('operacion_id',$operacion_id);
    }
    public function postUpdateexamen()
    {
        $data['vencimiento_id'] = Input::get('examen');
        $data['fecha']= Input::get('fecha');
        $data['caduca']= Input::get('caduca');
        $data['obs']= Input::get('obs');

        $examen = TrabajadorVencimiento::find($data['vencimiento_id']);

        $examen->fecha_vencimiento = $data['fecha'];
        $examen->caduca = $data['caduca'];
        $examen->observaciones = $data['obs'];
        $success = $examen->save();

        $success = $success ? 1 : 0;

        return Response::json(array(
            'success' => $success,
            'data'   => 'La fecha de vencimiento se actualizó correctamente'
        ));
    }

    public function getAddexamen($trabajador_id, $operacion_id,$proyecto)
    {
        $in_examen = TrabajadorVencimiento::where('trabajador_vencimiento.trabajador_id','=',$trabajador_id)
            ->where('trabajador_vencimiento.operacion_id','=',$operacion_id)
            ->select('trabajador_vencimiento.vencimiento_id')
            ->lists('trabajador_vencimiento.vencimiento_id');

        $examenes =  array('' => '[-- Seleccione un Examen --]') + \SSOLeica\Core\Model\EnumTables::where('type','=','ExamenMedico')
                    ->whereNotIn('id',$in_examen)
                    ->lists('name','id');

        return view('trabajador.addexamen')->with('examenes',$examenes);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        dd($id);
    }


}
