<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Model\Contrato;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Core\Repository\TrabajadorRepository;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Zofe\Rapyd\DataForm\DataForm;

class ContratoController extends Controller {


    /**
     * @var TrabajadorRepository
     */
    private $trabajador_repository;
    /**
     * @var OperacionRepository
     */
    private $operacion_repository;

    /**
     * @param TrabajadorRepository $trabajador_repository
     * @param OperacionRepository $operacion_repository
     */
    public function __construct(TrabajadorRepository $trabajador_repository, OperacionRepository $operacion_repository)
    {
        $this->middleware('workspace');
        $this->trabajador_repository = $trabajador_repository;
        $this->operacion_repository = $operacion_repository;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		dd('index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function anyCreate()
	{
        $query = $this->trabajador_repository->getTrabajadoresList(Session::get('pais_id'));

        $trabajadores = array();

        $trabajadores[''] = '[-– Seleccione –-]';

        foreach($query as $row)
        {
            $trabajadores[$row->id] = $row->nombre." ".$row->app_paterno." ".$row->app_materno;
        }

		$form = DataForm::source(new Contrato);

        $form->add('operacion_id', 'Proyecto','select')->option('','[-- Seleccione --]')->options($this->operacion_repository->getOperaciones(Session::get('pais_id'))->lists('nombre_operacion','id'))->rule('required');
        $form->add('nombre_contrato','Nombre Contrato','text')->rule('required|min:5');
        $form->add('gerencia','Gerencia','text')->rule('required|min:5');
        $form->add('supervisor_id','Ingeniero/Supervisor','select')
            ->options($trabajadores)
            ->rule('required')
            ->attr('data-live-search','true');
        $form->add('asesor_prev_riesgos_id','Asesor Prevención de Riesgos','select')
            ->options($trabajadores)
            ->rule('required')
            ->attr('data-live-search','true');
        $form->add('fecha_inicio','Fecha de Inicio', 'date')->format('d/m/Y', 'it')->rule('required');
        $form->add('fecha_fin','Fecha de Fin', 'date')->format('d/m/Y', 'it')->rule('required');
        $form->add('exist_cphs','CPHS','checkbox');
        $form->add('exist_subcontrato','Sub Contratos','checkbox');
        $form->add('is_activo','Activo','checkbox');
        $form->add('observaciones','Observaciones', 'redactor');

        $form->submit('Guardar');
        $form->link("/operacion","Cancelar");

        $form->build();

        return $form->view('contrato.create', compact('form'));
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function anyEdit($id)
	{
		dd('edit');
	}

    public function getTrabajadoreslist()
    {
        $q = Input::get('q');
        $pais_id = Session::get('pais_id');

        return $this->trabajador_repository->getTrabajadoresListAC($q,$pais_id);
    }

}
