<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 14/07/15
 * Time: 12:05 PM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\EstadisticaSeguridad;

class EstadisticasRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed $query
     */
    function model()
    {
        return 'SSOLeica\Core\Model\EstadisticaSeguridad';
    }

    public  function getQueryEstadisticasSeguridad($pais_id)
    {
        $query = EstadisticaSeguridad::join('contrato','contrato.id','=','estadistica_seguridad.contrato_id')
                ->join('month','month.id','=','estadistica_seguridad.month_id')
                ->join('operacion','operacion.id','=','contrato.operacion_id')
                ->where('operacion.pais_id',$pais_id)
                ->select('estadistica_seguridad.*')
                ->addSelect('operacion.nombre_operacion as proyecto')
                ->addSelect('contrato.nombre_contrato as contrato')
                ->addSelect('month.year')
                ->addSelect('month.nombre as mes');

        return $query;
    }

    public function getEstadistica($id)
    {
        $std = EstadisticaSeguridad::where('id','=',$id)->get()
            ->load('contrato.operacion')
            ->load('mes')
            ->first();

        return $std;
    }
}