<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 17/07/15
 * Time: 7:27 AM
 */

namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {

    public function permisos()
    {
        return $this->belongsToMany('SSOLeica\Core\Model\Permission', 'permission_role', 'role_id','permission_id');
    }

} 