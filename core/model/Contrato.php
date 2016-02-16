<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SSOLeica\Core\Traits\UpdatedBy;
use SSOLeica\Events\ContratoWasSaved;

class Contrato extends Model {

    use UpdatedBy,SoftDeletes;

    protected $table = 'contrato';

    public function save(array $options = array())
    {
        $this->attributes['updated_by'] = $this->getUpdated();
        $val = parent::save($options);

        \Event::fire(new ContratoWasSaved($this));

        return $val;
    }


    public function trabajadores()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorContrato');
    }

    public function examenes_medicos()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorContratoExamMedico');
    }

    public function operacion()
    {
        return $this->belongsTo('SSOLeica\Core\Model\Operacion');
    }

}
