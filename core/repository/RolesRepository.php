<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 24/02/16
 * Time: 6:01 PM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;

class RolesRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Role';
    }
}