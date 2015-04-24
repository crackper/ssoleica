<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class TrabajadorOperacionExamMedico extends Model {

	protected $table = 'trabajador_operacion_exam_medico';
    protected $primaryKey = array('trabajador_id','operacion_id','exam_medico_id');

    public function operacion()
    {
        return $this->hasOne('SSOLeica\Core\Model\Operacion');
    }

    public function examen()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreignKey= 'id',$localKey='exam_medico_id');
    }

}
