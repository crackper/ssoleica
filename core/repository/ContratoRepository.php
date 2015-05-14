<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 13/05/15
 * Time: 9:21 AM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;

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
}