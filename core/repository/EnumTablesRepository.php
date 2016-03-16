<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 30/04/15
 * Time: 9:47 AM
 */

namespace SSOLeica\Core\Repository;

use SSOLeica\Core\Helpers\EnumTable;
use SSOLeica\Core\Helpers\EnumType;
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
        $query = EnumTables::where('type','=',EnumType::Cargo)->get();

        return $query;
    }

    function getPaises()
    {
        $query = EnumTables::where('type','=',EnumType::Pais)->get();

        return $query;
    }

    function getProfesiones()
    {
        $query = EnumTables::where('type','=',EnumType::Profesion)->get();

        return $query;
    }

    function getEnumTables($type = "%")
    {
        $query = EnumTables::where('type','like',$type)->get();

        return $query;
    }

    function getPartesAfectadas()
    {
        $query = EnumTables::where('type','=',EnumType::ParteAfectada)->get();

        return $query;
    }

    function getConsecuencias()
    {
        $query = EnumTables::where('type','=',EnumType::Consecuencia)->get();

        return $query;
    }

    function getEntidades()
    {
        $query = EnumTables::where('type','=',EnumType::Entidad)->get();

        return $query;
    }

    function getJornadas()
    {
        $query = EnumTables::where('type','=',EnumType::Jornada)->get();

        return $query;
    }


    public function getExamenesDisponibles($trabajador_id, $operacion_id)
    {
        $in_examen = TrabajadorVencimiento::where('trabajador_vencimiento.trabajador_id','=',$trabajador_id)
            ->where('trabajador_vencimiento.operacion_id','=',$operacion_id)
            ->select('trabajador_vencimiento.vencimiento_id')
            ->lists('trabajador_vencimiento.vencimiento_id');

        $query = EnumTables::where('type','=',EnumType::ExamenMedico)
            ->whereNotIn('id',$in_examen)
            ->lists('name','id');

        return $query;
    }

    public function getDocumentosDisponibles($trabajador_id)
    {
        $in_examen = TrabajadorVencimiento::where('trabajador_vencimiento.trabajador_id','=',$trabajador_id)
            ->select('trabajador_vencimiento.vencimiento_id')
            ->lists('trabajador_vencimiento.vencimiento_id');

        $query = EnumTables::where('type','=',EnumType::Documento)
            ->whereNotIn('id',$in_examen)
            ->lists('name','id');

        return $query;
    }

    public function getTypes()
    {
        $query = EnumTables::distinct()->select('type')->orderBy('type','ASC');

        return $query;
    }
}