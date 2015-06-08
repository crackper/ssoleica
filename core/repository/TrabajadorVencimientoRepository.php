<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 1/06/15
 * Time: 2:38 PM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\TrabajadorVencimiento;

class TrabajadorVencimientoRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\TrabajadorVencimiento';
    }

    public  function getExamenesMedicos($trabajador_id,$operacion_id)
    {
        $query = TrabajadorVencimiento::join('enum_tables','enum_tables.id','=','trabajador_vencimiento.vencimiento_id')
            ->where('trabajador_vencimiento.trabajador_id','=',$trabajador_id)
            ->where('trabajador_vencimiento.operacion_id','=',$operacion_id)
            ->where('enum_tables.type','=','ExamenMedico')
            ->select('trabajador_vencimiento.*')
            ->addSelect('enum_tables.name as examen_medico')
            ->get();


        return $query;
    }

    public  function getDocumentos($trabajador_id)
    {
        $query = TrabajadorVencimiento::join('enum_tables','enum_tables.id','=','trabajador_vencimiento.vencimiento_id')
            ->where('trabajador_vencimiento.trabajador_id','=',$trabajador_id)
            ->where('enum_tables.type','=','Documento')
            ->select('trabajador_vencimiento.*')
            ->addSelect('enum_tables.name as documento')
            ->get();


        return $query;
    }
}