<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class Operacion extends Model {

    protected $table = 'operacion';

    public function trabajadores()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorOperacion');
    }

    public function examenes_medicos()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorOperacionExamMedico');
    }

}
