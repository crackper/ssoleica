<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class CargosTrabajador extends Model {

    use UpdatedBy;

    protected $table = 'cargos_trabajador';

}
