<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 7/03/17
 * Time: 8:42 AM
 */

namespace SSOLeica\Core\Repository;


use SSOLeica\Core\Data\Repository;

class ConfigurationsRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Configurations';
    }
}