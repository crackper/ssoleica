<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class TrabajadorVencimiento extends Model {

    protected $table = 'trabajador_vencimiento';

    /*public function operacion()
    {
        return $this->hasOne('SSOLeica\Core\Model\Contrato');
    }

    public function examen()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreignKey= 'id',$localKey='vencimiento_id');
    }*/

}
