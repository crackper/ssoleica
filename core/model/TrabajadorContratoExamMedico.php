<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class TrabajadorContratoExamMedico extends Model {

    protected $table = 'trabajador_contrato_exam_medico';
    protected $primaryKey = array('trabajador_id','contrato_id','exam_medico_id');

    public function operacion()
    {
        return $this->hasOne('SSOLeica\Core\Model\Contrato');
    }

    public function examen()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreignKey= 'id',$localKey='exam_medico_id');
    }

}
