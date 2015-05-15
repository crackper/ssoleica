<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class Operacion extends Model {

    protected $table = 'operacion';

    public function contratos()
    {
        return $this->hasMany('SSOLeica\Core\Model\Contrato');//,$foreingKey='id',$localKey='trabajador_id');
    }

}
