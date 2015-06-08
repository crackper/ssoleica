<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 30/04/15
 * Time: 9:47 AM
 */

namespace SSOLeica\Core\Repository;

use SSOLeica\Core\Model\EnumTables;
use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\TrabajadorVencimiento;

class EnumTablesRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\EnumTables';
    }

    function getCargos()
    {
        $query = EnumTables::where('type','=','Cargo')->get();

        return $query;
    }

    function getPaises()
    {
        $query = EnumTables::where('type','=','Pais')->get();

        return $query;
    }

    function getProfesiones()
    {
        $query = EnumTables::where('type','=','Profesion')->get();

        return $query;
    }

    public function getExamenesDisponibles($trabajador_id, $operacion_id)
    {
        $in_examen = TrabajadorVencimiento::where('trabajador_vencimiento.trabajador_id','=',$trabajador_id)
            ->where('trabajador_vencimiento.operacion_id','=',$operacion_id)
            ->select('trabajador_vencimiento.vencimiento_id')
            ->lists('trabajador_vencimiento.vencimiento_id');

        $query = EnumTables::where('type','=','ExamenMedico')
            ->whereNotIn('id',$in_examen)
            ->lists('name','id');

        return $query;
    }

    public function getDocumentosDisponibles($trabajador_id)
    {
        $in_examen = TrabajadorVencimiento::where('trabajador_vencimiento.trabajador_id','=',$trabajador_id)
            ->select('trabajador_vencimiento.vencimiento_id')
            ->lists('trabajador_vencimiento.vencimiento_id');

        $query = EnumTables::where('type','=','Documento')
            ->whereNotIn('id',$in_examen)
            ->lists('name','id');

        return $query;
    }
}