<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Events\ContratoWasSaved;

class Contrato extends Model {

    protected $table = 'contrato';

    public function save(array $options = array())
    {
        parent::save($options);

        \Event::fire(new ContratoWasSaved($this));

        return true;
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
