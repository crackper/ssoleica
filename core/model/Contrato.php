<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model {

    protected $table = 'contrato';

    public function trabajadores()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorContrato');
    }

    public function examenes_medicos()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorContratoExamMedico');
    }

}
