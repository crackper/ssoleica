<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class Operacion extends Model {

    use UpdatedBy;

    protected $table = 'operacion';

    public function contratos()
    {
        return $this->hasMany('SSOLeica\Core\Model\Contrato');//,$foreingKey='id',$localKey='trabajador_id');
    }
}
