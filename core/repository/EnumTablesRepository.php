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
}