<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class TrabajadorContrato extends Model {

    use UpdatedBy;

    protected $table = 'trabajador_contrato';

    //protected $primaryKey = array('trabajador_id','contrato_id');

    public function trabajador()
    {
        return $this->belongsTo('SSOLeica\Core\Model\Trabajador')->orderBy('app_paterno','desc');
    }

    public function contrato()
    {
        return $this->belongsTo('SSOLeica\Core\Model\Contrato');
    }

    public function save(array $options = array())
    {
        $this->attributes['updated_by'] = $this->getUpdated();

        return parent::save($options);
    }

}
