<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 12/05/15
 * Time: 7:05 PM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\Operacion;

class OperacionRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Operacion';
    }

    /**
     * @param $pais_id
     * @return mixed
     */
    function getOperaciones($pais_id)
    {
        $query = Operacion::where('pais_id','=',$pais_id);

        return $query;
    }
}