<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 26/05/16
 * Time: 8:28 PM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;

class MedidasSeguridadRepository extends Repository{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\IncidenteMedidasSeguridad';
    }
}