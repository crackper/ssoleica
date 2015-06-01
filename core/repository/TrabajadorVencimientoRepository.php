<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 1/06/15
 * Time: 2:38 PM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;

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
}