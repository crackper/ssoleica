<?php namespace SSOLeica\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Nayjest\Grids\EloquentDataRow;
use SSOLeica\Core\Helpers\Helpers;
use SSOLeica\Core\Helpers\Timezone;
use SSOLeica\Core\Model\Contrato;
use SSOLeica\Core\Model\EnumCategories;
use SSOLeica\Core\Model\Trabajador;
use SSOLeica\Core\Model\TrabajadorVencimiento;
use SSOLeica\Core\Repository\ContratoRepository;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Core\Repository\TrabajadorRepository;
use SSOLeica\Core\Repository\TrabajadorVencimientoRepository;
use SSOLeica\Http\Requests;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
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
use Zizaco\Entrust\Entrust;
use Zofe\Rapyd\DataForm\DataForm;


class TrabajadorController extends Controller
{
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
     * @var TrabajadorVencimientoRepository
     */
    private $trabajadorVencimientoRepository;

    private $pais;
    private $timezone;


    /**
     * @param Trabajador $trabajador
     * @param EnumTablesRepository $enumTablesRepository
     * @param Trabajador $trabajadorRepository
     * @param ContratoRepository $contratoRepository
     * @param OperacionRepository $operacionRepository
     * @param TrabajadorVencimientoRepository $trabajadorVencimientoRepository
     * @internal param EnumTables $enum_tables
     */
    public function __construct(EnumTablesRepository $enumTablesRepository,
                                TrabajadorRepository $trabajadorRepository,
                                ContratoRepository $contratoRepository,
                                OperacionRepository $operacionRepository,
                                TrabajadorVencimientoRepository $trabajadorVencimientoRepository)
    {
        $this->middleware('auth');
        $this->middleware('workspace');

        $this->trabajadorRepository = $trabajadorRepository;
        $this->contratoRepository = $contratoRepository;
        $this->operacionRepository = $operacionRepository;
        $this->enumTablesRepository = $enumTablesRepository;
        $this->trabajadorVencimientoRepository = $trabajadorVencimientoRepository;

        $this->pais = Session::get('pais_id');
        $this->timezone = Session::get('timezone');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $query = $this->trabajadorRepository->getTrabajadores()->where('pais_id', '=', $this->pais);
        //dd($query->first()->fullname);
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
                    ->setCallback(function ($val,EloquentDataRow $row) {
                        $icon_edit = "<a href='/trabajador/edit/{$row->getSrc()->id}' data-toggle='tooltip' data-placement='left' title='Editar Trabajador'><span class='glyphicon glyphicon-user'></span> {$val}</a>";
                        return $icon_edit;
                    })
                    ->addFilter(
                        (new FilterConfig)
                            ->setFilteringFunc(function ($val, EloquentDataProvider $provider) {
                                $provider->getBuilder()
				    //->where('deleted_at','')
				    ->Where(DB::raw('upper(app_paterno)'), 'like', '%' . strtoupper($val) . '%')
                                    ->orWhere(DB::raw('upper(app_materno)'), 'like', '%' . strtoupper($val) . '%')
                                    ->orWhere(DB::raw('upper(nombre)'), 'like', '%' . strtoupper($val) . '%');
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
                        $icon_remove = "<a href='/trabajador/remove/$val' data-toggle='tooltip' data-placement='left' title='Eliminar Trabajador' onclick=\"return confirm('Desea eliminar el trabajdor')\"  ><span class='glyphicon glyphicon-trash'></span></a>";
                        $icon_pdf = "<a href='/trabajador/ficha/$val' data-toggle='tooltip' data-placement='left' title='Imprimir Ficha' ><span class='fa fa-print'></span></a>";

                        return $icon_edit . ' ' . $icon_remove.' '. $icon_pdf;
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
                                    ->setDefaultValue(['2005-01-01', date('Y-m-d')])
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
        $trabajador = $this->trabajadorRepository->find($id);

        if( is_null($trabajador) || $trabajador->pais_id != $this->pais)
        {
            return new RedirectResponse(url('/trabajador'));
        }

        $pais = $this->enumTablesRepository->find($this->pais)->load('categorias.categoria');

        $licencias = array();
        $licencias[""] = "[- Seleccione -]";
        foreach ($pais->categorias as $row) {
            $licencias[$row->enum_value_id] = $row->categoria->name;
        }

        $edit = DataForm::source($trabajador);

        $edit->add('dni', 'DNI', 'text')->rule('required|min:8');
        $edit->add('nombre', 'Nombre', 'text')->rule('required|max:100');
        $edit->add('app_paterno', 'Apellido Paterno', 'text')->rule('required');
        $edit->add('app_materno', 'Apellido Materno', 'text')->rule('required');
        $edit->add('sexo', 'Sexo', 'radiogroup')->option('F', 'Femenino')->option('M', 'Masculino');
        $edit->add('fecha_nacimiento', 'Fecha de Nacimiento', 'date')->format('d/m/Y', 'es')->rule('required');
        $edit->add('estado_civil', 'Estado Civil', 'select')->options(array('Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo', 'Divorciado' => 'Divorciado', 'Conviviente' => 'Conviviente'));
        $edit->add('direccion', 'Direccion', 'text');
        $edit->add('email', 'E-mail', 'text')->rule('email');
        $edit->add('nro_telefono', 'Nro. Telefono', 'text');
        $edit->add('fecha_ingreso', 'Fecha de Ingreso', 'date')->format('d/m/Y', 'es')->rule('required');
        $edit->add('profesion_id', 'Profesion', 'select')->options($this->enumTablesRepository->getProfesiones()->lists('name', 'id'));
        $edit->add('cargo_id', 'Cargo', 'select')->options($this->enumTablesRepository->getCargos()->lists('name', 'id'));
        $edit->add('fecha_ini_cargo', 'Fecha Inicio Cargo', 'date')->format('d/m/Y', 'es')->rule('required');
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
        //emfermedades
        $edit->add('Enfermedades','Enfermedades', 'text');
        $edit->add('Medicamentos','Medicamentos', 'text');
        $edit->add('Alergias','Alergias', 'text');
        $edit->add('Accidentes','Accidentes', 'text');
        //otros datos

        $tallas = array(''=>'[- Seleccione -]','XXS'=>'XXS','XS'=>'XS','S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','XXL'=>'XXL');
        $zapatos = array(''=>'[- Seleccione -]','35'=>'35','35 1/2'=>'35 1/2','36'=>'36','37'=>'37','37 1/2'=>'37 1/2','38'=>'38','38 1/2'=>'38 1/2','39'=>'39','40'=>'40','41'=>'41','42'=>'42','43'=>'43','44'=>'44','45'=>'45','46 1/2'=>'46 1/2','48 1/2'=>'48 1/2');
        $pantalon = array(''=>'[- Seleccione -]','28'=>'28','30'=>'30','32'=>'32','34'=>'34','36'=>'36','38'=>'38','40'=>'40','42'=>'42' );

        $edit->add('TCamisa', 'Talla Camisa', 'select')->options($tallas);
        $edit->add('TZapatos', 'Talla Zapatos', 'select')->options($zapatos);
        $edit->add('TPolo', 'Talla Polo', 'select')->options($tallas);
        $edit->add('TGuantes', 'Talla Guantes', 'select')->options($tallas);
        $edit->add('TRespirador', 'Talla Respirador', 'select')->options($tallas);
        $edit->add('TCasaca', 'Talla Casaca', 'select')->options($tallas);
        $edit->add('TChaleco', 'Talla Chaleco', 'select')->options($tallas);
        $edit->add('TPantalon', 'Talla Pantalon', 'select')->options($pantalon);

        $edit->submit('Guardar');
        $edit->link("/trabajador", "Cancelar");

        $text = $trabajador->nombre.' '.$trabajador->app_paterno.' '.$trabajador->app_materno;

        $edit->saved(function () use ($edit) {

            Session::flash('message', 'La información del Trabajador se Registró Correctamente');

            return new RedirectResponse(url('trabajador/edit/' . $edit->model->id));
        });

        $edit->built();

        return $edit->view('trabajador.edit', compact('edit','id','text'));
    }


    /**
     * @Middleware("permission:create_trabajador")
     */
    public function anyCreate()
    {

        $pais = $this->enumTablesRepository->find($this->pais)->load('categorias.categoria');

        $licencias = array();
        $licencias[""] = "[- Seleccione -]";
        foreach ($pais->categorias as $row) {
            $licencias[$row->enum_value_id] = $row->categoria->name;
        }

        $edit = DataForm::source(new Trabajador);

        $edit->add('pais_id', '', 'hidden')->insertValue($this->pais);
        $edit->add('dni', 'DNI', 'text')->rule('required|min:8|unique:trabajador');
        $edit->add('nombre', 'Nombre', 'text')->rule('required|max:100');
        $edit->add('app_paterno', 'Apellido Paterno', 'text')->rule('required');
        $edit->add('app_materno', 'Apellido Materno', 'text')->rule('required');
        $edit->add('sexo', 'Sexo', 'radiogroup')->option('F', 'Femenino')->option('M', 'Masculino')->rule('required');
        $edit->add('fecha_nacimiento', 'Fecha de Nacimiento', 'date')->rule('required'); //->format('d/m/Y', 'es')
        $edit->add('estado_civil', 'Estado Civil', 'select')->options(array('' => '[- Seleccione -]','Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo', 'Divorciado' => 'Divorciado', 'Conviviente' => 'Conviviente'))->rule('required');
        $edit->add('direccion', 'Direccion', 'text');
        $edit->add('email', 'E-mail', 'text')->rule('email');
        $edit->add('nro_telefono', 'Nro. Telefono', 'text');
        $edit->add('fecha_ingreso', 'Fecha de Ingreso', 'date')->format('d/m/Y', 'es') ->rule('required');//->format('d/m/Y', 'es')
        $edit->add('profesion_id', 'Profesion', 'select')->options(array('' => '[- Seleccione -]') + $this->enumTablesRepository->getProfesiones()->lists('name', 'id'))->rule('required');
        $edit->add('cargo_id', 'Cargo', 'select')->options(array('' => '[- Seleccione -]') + $this->enumTablesRepository->getCargos()->lists('name', 'id'))->rule('required');
        $edit->add('fecha_ini_cargo', 'Fecha Inicio Cargo', 'date')->format('d/m/Y', 'es')->rule('required');
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
            Session::flash('message', 'La información del Trabajador se Registro Correctamente');

            return new RedirectResponse(url('trabajador/edit/' . $edit->model->id));
            // $edit->message("ok record saved");
            //$edit->link("/trabajador","Next Step");

        });

        $edit->built();

        return $edit->view('trabajador.create', compact('edit'));
    }

    /**
     * @return json
     */
    public function postUpdatefecha()
    {
        $contrato_id = Input::get('contrato');

        $changeContrato = array(
            'fecha_vencimiento' => Timezone::toUTC(Input::get('fecha').' 23:59:59',$this->timezone),
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
        $fechaFin = Timezone::toUTC(Input::get('fecFinActual').' 00:00:00',$this->timezone);
        $data['fecha_inicio'] = Timezone::toUTC(Input::get('fecIniCambio'),$this->timezone);
        $data['contrato_id'] = Input::get('contrato_id');

        $contrato = $this->contratoRepository->find($data['contrato_id']);

        $success = 0;
        $msg = "";

        if($contrato->fecha_inicio > $data['fecha_inicio'])
        {
            $msg = "La fecha de inicio del trabajador es anterior a la fecha de incio del contrato.";
        }
        else
        {
            $success = $this->trabajadorRepository->updateContrato($id,$data,$fechaFin);

            $msg = $success == 1 ? 'La información se actualizó correctamente' : "Error: No se puedo actualizar el contrato";
        }

        return Response::json(array(
            'success' => $success,
            'data'   => $msg
        ));
    }

    public function getAsignarcontrato($id)
    {
        $operaciones = $this->operacionRepository->getOperacionesDiponiblesByTrabajador($id,$this->pais);

        $query = array('' => '[-- Seleccione un proyecto--]') + $operaciones;

        $data['proyectos'] = $query;
        $data['trabajador_id'] = $id;

        return view('trabajador.asignarContrato')->with('data',$data);
    }

    public function postAsignarcontrato($id)
    {
        $data['trabajador_id'] = $id;
        $data['contrato_id'] = Input::get('contrato_id');
        $data['fecha_inicio'] = Timezone::toUTC(input::get('fecInicio'),$this->timezone);
        $data['nro_fotocheck'] = Input::get('nroFotocheck');
        $data['fecha_vencimiento'] = Timezone::toUTC(Input::get('fecVencimiento').' 00:00:00',$this->timezone);

        $contrato = $this->contratoRepository->find($data['contrato_id']);

        $success = 0;
        $msg = "";

        if($contrato->fecha_inicio > $data['fecha_inicio'])
        {
            $msg = "La fecha de inicio del trabajador es anterior a la fecha de incio del contrato.";
        }
        else
        {
            $success = $this->contratoRepository->registarContratoTrabajador($data);
            $msg = $success ? "La informacion de guardo correctamente." : "Error: No se pudo guardar la información";
        }

        return Response::json(array(
            'success' => $success,
            'data'   => $msg
        ));

    }

    public function getContratos($id = 0)
    {
        $query = $this->contratoRepository->getListsContrato($id);
        return Response::json($query);
    }

    public function getProyectostrabajador($trabajador_id)
    {
        $data = $this->operacionRepository->getListsOperacionesByTrabajador($trabajador_id);

        return Response::json($data);
    }

    public  function getExamenesmedicos($trabajador_id, $operacion_id,$proyecto)
    {
        $query = $this->trabajadorVencimientoRepository->getExamenesMedicos($trabajador_id,$operacion_id);

        return view('trabajador.examenes')->with('data',$query)
            ->with('proyecto',$proyecto)
            ->with('trabajador_id',$trabajador_id)
            ->with('operacion_id',$operacion_id);
    }

    public function postUpdatevencimiento()
    {
        $vencimiento_id             = Input::get('vencimiento');
        $data['fecha_vencimiento']  = Timezone::toUTC(Input::get('fecha').' 00:00:00',$this->timezone);
        $data['caduca']             = Input::get('caduca');
        $data['observaciones']      = Input::get('obs');

        $examen = $this->trabajadorVencimientoRepository->update($data,$vencimiento_id);

        $success = is_null($examen) ? 0 : 1;

        $msg = $success == 1 ? 'La fecha de vencimiento se actualizó correctamente' : 'La fecha de vencimiento no se pudo actualizó' ;

        return Response::json(array(
            'success' => $success,
            'data'   => $msg
        ));
    }

    public function getAddvencimiento($type,$trabajador_id, $operacion_id)
    {
        if($type == 'examen')
        {
            $vencimientos =  array('' => '[-- Seleccione un Examen --]') + $this->enumTablesRepository->getExamenesDisponibles($trabajador_id,$operacion_id);
            $title = 'Exámen Médico';
            $label = 'Exámen';
        }
        elseif($type == 'documento')
        {
            $vencimientos =  array('' => '[-- Seleccione un Documento --]') + $this->enumTablesRepository->getDocumentosDisponibles($trabajador_id);
            $title = 'Documento';
            $label = 'Documento';
        }

        return view('trabajador.addvencimiento')
                ->with('vencimientos',$vencimientos)
                ->with('trabajador_id',$trabajador_id)
                ->with('operacion_id',$operacion_id)
                ->with('label',$label)
                ->with('title',$title);

    }

    public function postAddvencimiento($trabajador_id, $operacion_id)
    {
        $data['trabajador_id']      = $trabajador_id;
        $data['operacion_id']       = $operacion_id == 0 ? null: $operacion_id ;
        $data['vencimiento_id']     = Input::get('vencimiento_id');
        $data['caduca']             = Input::get('caduca');
        $data['fecha_vencimiento']  = Timezone::toUTC(Input::get('fecVencimiento').' 00:00:00',$this->timezone);
        $data['observaciones']      = Input::get('observaciones');

        $examen = $this->trabajadorVencimientoRepository->create($data);

        $examen['fecha_vencimiento'] = $data['fecha_vencimiento'];

        $success = is_null($examen) ? 0 : 1;

        $msg = $success == 1 ? 'La información se guardó Correctamente' : 'No se pudo guardar el examen' ;

        return Response::json(array(
            'success' => $success,
            'data'   => $examen,
            'msg' => $msg
        ));
    }

    public  function getDocumentos($trabajador_id)
    {
        $query = $this->trabajadorVencimientoRepository->getDocumentos($trabajador_id);

        return view('trabajador.documentos')->with('data',$query)
            ->with('trabajador_id',$trabajador_id);
    }


    /**
     * @param $id
     */
    //public function delete($id)
    //{
       // dd($id);
    //}

    public function  getFicha($id=0)
    {

        $trabajador = $this->trabajadorRepository->find($id);

        if(is_null($trabajador))
            return new RedirectResponse(url('/trabajador/'));

        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=Ficha_".str_replace(" ","_",$trabajador->nombre)."_".$trabajador->app_paterno.".pdf");

        define ("JAVA_HOSTS", "127.0.0.1:8080");
        define ("JAVA_SERVLET", "/JavaBridge/JavaBridge.phpjavabridge");

        require_once base_path("java/Java.inc");

        session_start();

        $ctx = java_context()->getServletContext();

        $birtReportEngine =  java("org.eclipse.birt.php.birtengine.BirtEngine")->getBirtEngine($ctx);
        java_context()->onShutdown(java("org.eclipse.birt.php.birtengine.BirtEngine")->getShutdownHook());


        try{

            $report = $birtReportEngine->openReportDesign(base_path("/reports/Ficha_Personal.rptdesign"));
            $task = $birtReportEngine->createRunAndRenderTask($report);

            $task->setParameterValue("idTrabajador", new \java("java.lang.Integer", $id));

            $taskOptions = new \java("org.eclipse.birt.report.engine.api.PDFRenderOption");
            $outputStream = new \java("java.io.ByteArrayOutputStream");

            $taskOptions->setOutputStream($outputStream);

            $taskOptions->setOption("pdfRenderOption.pageOverflow", "pdfRenderOption.fitToPage");
            $taskOptions->setOption("pdfRenderOption.setEmbededFont", false);


            $taskOptions->setOutputFormat("pdf");

            $task->setRenderOption( $taskOptions );
            $task->run();
            $task->close();

        } catch (JavaException $e) {
            echo $e;

        }

        echo java_values($outputStream->toByteArray());    
    }

 public function getRemove($id)
    {
	$trabajador = $this->trabajadorRepository->find($id);

       if(is_null($trabajador))
            return new RedirectResponse(url('/trabajador/'));

        $this->trabajadorRepository->remove($id);

        Session::flash('message', 'El trabajador fue eliminado Correctamente');

return new RedirectResponse(url('/trabajador/'));
    }

}
