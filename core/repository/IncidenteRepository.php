<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 23/12/15
 * Time: 8:02 AM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;

class IncidenteRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Incidente';
    }
}