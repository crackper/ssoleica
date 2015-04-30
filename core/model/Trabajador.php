<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model {

    protected $table = 'trabajador';



    public function operaciones()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorOperacion');//,$foreingKey='id',$localKey='trabajador_id');
    }

    public function examenes_medicos()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorOperacionExamMedico');
    }

    public function profesion()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreignKey= 'id',$localKey='profesion_id');//,$foreignKey= 'profesion_id',$localKey='id'
    }

    public function pais()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreignKey= 'id',$localKey='pais_id');
    }

    public function getFullNameAttribute(){
        return $this->attributes['apellidos'] .', '.$this->attributes['nombre'] ;
    }

}
