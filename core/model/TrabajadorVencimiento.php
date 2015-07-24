<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class TrabajadorVencimiento extends Model {

    use UpdatedBy;

    protected $table = 'trabajador_vencimiento';

    protected $fillable = array('trabajador_id', 'operacion_id', 'vencimiento_id','type','caduca','fecha_vencimiento','observaciones');

    /*public function operacion()
    {
        return $this->hasOne('SSOLeica\Core\Model\Contrato');
    }

    public function examen()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreignKey= 'id',$localKey='vencimiento_id');
    }*/

    public function save(array $options = array())
    {
        $this->attributes['updated_by'] = $this->getUpdated();

        return parent::save($options);
    }

}
