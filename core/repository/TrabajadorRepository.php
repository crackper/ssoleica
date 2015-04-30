<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 24/04/15
 * Time: 12:59 PM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Model\Trabajador;
use SSOLeica\Core\Data\Repository;

class TrabajadorRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Trabajador';
    }

    function getTrabajadores()
    {
        $query = Trabajador::join('enum_tables','trabajador.cargo_id','=','enum_tables.id')
            ->select('trabajador.*')
            ->addSelect('enum_tables.name as cargo');

        return $query;
    }
}