<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 13/05/15
 * Time: 9:21 AM
 */

namespace SSOLeica\Core\Repository;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\Contrato;
use SSOLeica\Core\Model\ShiftContratoTrabajador;
use SSOLeica\Core\Model\TrabajadorContrato;

class ContratoRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Contrato';
    }

    /**
     * @param $pais_id
     * @return object
     */
    function getContratos($pais_id)
    {
        $query = Contrato::join('operacion','contrato.operacion_id','=','operacion.id')
                ->join('trabajador as s','contrato.supervisor_id','=','s.id')
                ->join('trabajador as atr','contrato.asesor_prev_riesgos_id','=','atr.id')
                ->where('operacion.pais_id','=',$pais_id)
                ->select('contrato.*')
                ->addSelect('operacion.nombre_operacion as proyecto')
                ->addSelect('s.nombre as nombre_supervisor')
                ->addSelect('s.app_paterno as app_paterno_supervisor')
                ->addSelect(DB::raw("(s.nombre || ' ' || s.app_paterno) AS supervisor"))
                //->addSelect(DB::raw('CONCAT(s.nombre, " ", s.app_paterno) AS supervisor'))
                ->addSelect('atr.nombre as nombre_atr')
                ->addSelect('atr.app_paterno as app_paterno_atr')
                ->addSelect(DB::raw("(atr.nombre || ' ' || atr.app_paterno) AS apr"));
                //->addSelect(DB::raw('CONCAT(atr.nombre, " ", atr.app_paterno) AS apr'));

        return $query;
    }

    function getContrato($id,$pais_id)
    {
        $query = Contrato::join('operacion','contrato.operacion_id','=','operacion.id')
            ->where('operacion.pais_id',$pais_id)
            ->where('contrato.id',$id)
            ->select('contrato.*');

        return $query->first();
    }

    /**
     * Devuelve contratos diponibles para un trabajador en funcion al contrato
     * ya asignado
     * @param $proyecto_id
     * @param $contrato_id
     * @param $data
     * @return lists('nombre_contrato', 'id');
     */
    public function getContratosDisponibles($proyecto_id, $contrato_id)
    {
        $data = Contrato::where('operacion_id', '=', $proyecto_id)
            ->whereNotIn('id', array($contrato_id))
            ->lists('nombre_contrato', 'id');

        return $data;
    }

    /**
     * @param $data
     * @return bool
     */
    public function registarContratoTrabajador($data)
    {
        $success = 0;

        try{
            DB::connection()->getPdo()->beginTransaction();

            $trabajador_contrato = new TrabajadorContrato;
            $trabajador_contrato->trabajador_id = $data['trabajador_id'];
            $trabajador_contrato->contrato_id = $data['contrato_id'];
            $trabajador_contrato->fecha_inicio = $data['fecha_inicio'];
            $trabajador_contrato->nro_fotocheck =  $data['nro_fotocheck'];
            $trabajador_contrato->fecha_vencimiento = $data['fecha_vencimiento'];
            $trabajador_contrato->is_activo = 1;
            $success = $trabajador_contrato->save();

            $shift_contato = new ShiftContratoTrabajador;
            $shift_contato->trabajador_contrato_id = $trabajador_contrato->id;
            $shift_contato->trabajador_id = $data['trabajador_id'];
            $shift_contato->contrato_id = $data['contrato_id'];
            $shift_contato->fecha_inicio = $data['fecha_inicio'];
            $shift_contato->save();

            DB::connection()->getPdo()->commit();
        }
        catch(\PDOException $ex){
            $success = 0;
            DB::connection()->getPdo()->rollback();
            Log::error('Error en ContratoRepository->registarContratoTrabajador(): '.$ex);
        }


        return $success;
    }

    public function getListsContrato($operacion_id)
    {
        return Contrato::where('operacion_id','=',$operacion_id)->where('is_activo','=',1)->lists('nombre_contrato','id');
    }

    public function getTrabajadores($contrato_id)
    {
        $trabajadores = TrabajadorContrato::where('contrato_id','=',$contrato_id)
            ->where('is_activo','=',true)
            ->get()->load('trabajador.cargo');

        return $trabajadores;
    }
}
