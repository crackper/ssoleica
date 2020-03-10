<?php namespace SSOLeica\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Repository\OperacionRepository;
use SSOLeica\Http\Requests;
use SSOLeica\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AlertasController extends Controller {

    /**
     * @var OperacionRepository
     */
    private $operacionRepository;

    private $pais;
    private $timezone;

    /**
     * @param OperacionRepository $operacionRepository
     */
    public  function __construct(OperacionRepository $operacionRepository)
    {
        $this->middleware('auth');
        $this->middleware('workspace');
        $this->operacionRepository = $operacionRepository;
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
		$proyectos = $this->operacionRepository->getOperaciones($this->pais)->get();

        $data_f = array();
        $data_e = array();
        $data_d = array();

        foreach($proyectos as $key=>$row)
        {
            //fotochecks
            $query_f = "select p.name as  pais,o.nombre_operacion as operacion, (t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
            $query_f .= "tc.nro_fotocheck as fotocheck, ";
            $query_f .= "tc.fecha_vencimiento at time zone 'utc' at time zone (p.data->>0)::text as fecha_vencimiento ";
            $query_f .= "from trabajador_contrato tc ";
            $query_f .= "inner join trabajador t on tc.trabajador_id = t.id ";
            $query_f .= "inner join contrato c on tc.contrato_id = c.id ";
            $query_f .= "inner join operacion o on c.operacion_id = o.id ";
            $query_f .= "inner join enum_tables p on o.pais_id = p.id ";
            $query_f .= "where t.deleted_at is null and (tc.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month' - interval '1 second')) ";
            $query_f .= "and p.id = :pais_id and operacion_id = :operacion_id order by tc.fecha_vencimiento";

            $fotochecks = DB::select(DB::Raw($query_f),array('pais_id' => $this->pais,'operacion_id'=>$row->id));

            if(count($fotochecks)>0)
            {
                $proyecto["proyecto"] = $row->nombre_operacion;
                $proyecto["fotochecks"]= $fotochecks;
                $data_f[]=$proyecto;
            }
        }



        foreach($proyectos as $key=>$row)
        {
            //examenes
            $query_e = "select p.name as  pais,o.nombre_operacion as operacion,v.type, ";
            $query_e .= "(t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
            $query_e .= "v.name as vencimiento, ";
            $query_e .= "tv.fecha_vencimiento at time zone 'utc' at time zone (p.data->>0)::text as fecha_vencimiento ";
            $query_e .= "from trabajador_vencimiento tv ";
            $query_e .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
            $query_e .= "inner join trabajador t on tv.trabajador_id = t.id ";
            $query_e .= "inner join operacion o on tv.operacion_id = o.id ";
            $query_e .= "inner join enum_tables p on o.pais_id = p.id ";
            $query_e .= "where t.deleted_at is null and tv.caduca = true and v.type = 'ExamenMedico' ";
            $query_e .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month' - interval '1 second')) ";
            $query_e .= "and p.id = :pais_id and o.id = :operacion_id ";
            $query_e .= "order by o.nombre_operacion,tv.fecha_vencimiento,t.app_paterno";

            $examenes = DB::select(DB::Raw($query_e),array('pais_id' => $this->pais,'operacion_id'=>$row->id));

            if(count($examenes)>0)
            {
                $proyecto_e["proyecto"] = $row->nombre_operacion;
                $proyecto_e["examenes"]= $examenes;
                $data_e[]=$proyecto_e;
            }
        }


        //documentos
        $query_d = "select p.name as  pais,v.type, ";
        $query_d .= "(t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
        $query_d .= "v.name as vencimiento, ";
        $query_d .= "tv.fecha_vencimiento at time zone 'utc' at time zone (p.data->>0)::text as fecha_vencimiento ";
        $query_d .= "from trabajador_vencimiento tv ";
        $query_d .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
        $query_d .= "inner join trabajador t on tv.trabajador_id = t.id ";
        $query_d .= "inner join enum_tables p on t.pais_id = p.id ";
        $query_d .= "where t.deleted_at is null and  tv.caduca = true and v.type = 'Documento' ";
        $query_d .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', now()) at time zone 'utc') and  ((DATE_TRUNC('month', now())  at time zone 'utc') + '1 month' - interval '1 second')) ";
        $query_d .= "and p.id = :pais_id ";
        $query_d .= "order by tv.fecha_vencimiento,t.app_paterno ";

        $documentos = DB::select(DB::Raw($query_d),array('pais_id' => $this->pais));

        if(count($documentos) > 0)
        {
            $proyecto_d["proyecto"] = "Otros Documentos";
            $proyecto_d["documentos"]= $documentos;
            $data_d[]=$proyecto_d;
        }

        return view('alertas.index')
            ->with('data_f',$data_f)
            ->with('data_e',$data_e)
            ->with('data_d',$data_d);
	}

    public function getNextMes()
    {
        $proyectos = $this->operacionRepository->getOperaciones($this->pais)->get();

        $data_f = array();
        $data_e = array();
        $data_d = array();

        foreach($proyectos as $key=>$row)
        {
            //fotochecks
            $query_f = "select p.name as  pais,o.nombre_operacion as operacion, (t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
            $query_f .= "tc.nro_fotocheck as fotocheck, ";
            $query_f .= "tc.fecha_vencimiento at time zone 'utc' at time zone (p.data->>0)::text as fecha_vencimiento ";
            $query_f .= "from trabajador_contrato tc ";
            $query_f .= "inner join trabajador t on tc.trabajador_id = t.id ";
            $query_f .= "inner join contrato c on tc.contrato_id = c.id ";
            $query_f .= "inner join operacion o on c.operacion_id = o.id ";
            $query_f .= "inner join enum_tables p on o.pais_id = p.id ";
            $query_f .= "where (tc.fecha_vencimiento  between (DATE_TRUNC('month', nextmes()) at time zone 'utc') and  ((DATE_TRUNC('month', nextmes())  at time zone 'utc') + '1 month' - interval '1 second')) ";
            $query_f .= "and p.id = :pais_id and operacion_id = :operacion_id order by tc.fecha_vencimiento";

            $fotochecks = DB::select(DB::Raw($query_f),array('pais_id' => $this->pais,'operacion_id'=>$row->id));

            if(count($fotochecks)>0)
            {
                $proyecto["proyecto"] = $row->nombre_operacion;
                $proyecto["fotochecks"]= $fotochecks;
                $data_f[]=$proyecto;
            }
        }



        foreach($proyectos as $key=>$row)
        {
            //examenes
            $query_e = "select p.name as  pais,o.nombre_operacion as operacion,v.type, ";
            $query_e .= "(t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
            $query_e .= "v.name as vencimiento, ";
            $query_e .= "tv.fecha_vencimiento at time zone 'utc' at time zone (p.data->>0)::text as fecha_vencimiento ";
            $query_e .= "from trabajador_vencimiento tv ";
            $query_e .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
            $query_e .= "inner join trabajador t on tv.trabajador_id = t.id ";
            $query_e .= "inner join operacion o on tv.operacion_id = o.id ";
            $query_e .= "inner join enum_tables p on o.pais_id = p.id ";
            $query_e .= "where tv.caduca = true and v.type = 'ExamenMedico' ";
            $query_e .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', nextmes()) at time zone 'utc') and  ((DATE_TRUNC('month', nextmes())  at time zone 'utc') + '1 month' - interval '1 second')) ";
            $query_e .= "and p.id = :pais_id and o.id = :operacion_id ";
            $query_e .= "order by o.nombre_operacion,tv.fecha_vencimiento,t.app_paterno";

            $examenes = DB::select(DB::Raw($query_e),array('pais_id' => $this->pais,'operacion_id'=>$row->id));

            if(count($examenes)>0)
            {
                $proyecto_e["proyecto"] = $row->nombre_operacion;
                $proyecto_e["examenes"]= $examenes;
                $data_e[]=$proyecto_e;
            }
        }


        //documentos
        $query_d = "select p.name as  pais,v.type, ";
        $query_d .= "(t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
        $query_d .= "v.name as vencimiento, ";
        $query_d .= "tv.fecha_vencimiento at time zone 'utc' at time zone (p.data->>0)::text as fecha_vencimiento ";
        $query_d .= "from trabajador_vencimiento tv ";
        $query_d .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
        $query_d .= "inner join trabajador t on tv.trabajador_id = t.id ";
        $query_d .= "inner join enum_tables p on t.pais_id = p.id ";
        $query_d .= "where tv.caduca = true and v.type = 'Documento' ";
        $query_d .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', nextmes()) at time zone 'utc') and  ((DATE_TRUNC('month', nextmes())  at time zone 'utc') + '1 month' - interval '1 second')) ";
        $query_d .= "and p.id = :pais_id ";
        $query_d .= "order by tv.fecha_vencimiento,t.app_paterno ";

        $documentos = DB::select(DB::Raw($query_d),array('pais_id' => $this->pais));

        if(count($documentos) > 0)
        {
            $proyecto_d["proyecto"] = "Otros Documentos";
            $proyecto_d["documentos"]= $documentos;
            $data_d[]=$proyecto_d;
        }

        return view('alertas.index')
            ->with('data_f',$data_f)
            ->with('data_e',$data_e)
            ->with('data_d',$data_d);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
