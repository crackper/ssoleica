<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class CargosTrabajador extends Model {

    use UpdatedBy;

    protected $table = 'cargos_trabajador';

    public function trabajador()
    {
        return $this->hasOne('SSOLeica\Core\Model\Trabajador',$foreingKey='id',$localKey='trabajador_id');
    }

    public function cargo()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreingKey='id',$localKey='cargo_id');
    }

}
