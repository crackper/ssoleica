<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class TrabajadorContrato extends Model {

    protected $table = 'trabajador_contrato';

    //protected $primaryKey = array('trabajador_id','contrato_id');

    public function trabajador()
    {
        return $this->belongsTo('SSOLeica\Core\Model\Trabajador');
    }

    public function contrato()
    {
        return $this->belongsTo('SSOLeica\Core\Model\Contrato');
    }

}
