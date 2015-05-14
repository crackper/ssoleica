<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 13/05/15
 * Time: 9:21 AM
 */

namespace SSOLeica\Core\Repository;


use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\Contrato;

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
                ->addSelect(DB::raw('CONCAT(s.nombre, " ", s.app_paterno) AS supervisor'))
                ->addSelect('atr.nombre as nombre_atr')
                ->addSelect('atr.app_paterno as app_paterno_atr')
                ->addSelect(DB::raw('CONCAT(atr.nombre, " ", atr.app_paterno) AS apr'));

        return $query;
    }
}