<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class TrabajadorOperacion extends Model {

    protected $table = 'trabajador_operacion';
    protected $primaryKey = array('trabajador_id','operacion_id');

    public function trabajador()
    {
        return $this->belongsTo('SSOLeica\Core\Model\Trabajador');
    }

    public function operacion()
    {
        return $this->belongsTo('SSOLeica\Core\Model\Operacion');
    }

}
