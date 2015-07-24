<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;
use SSOLeica\Events\TrabajadorWasSaved;

class Trabajador extends Model {

    use UpdatedBy;

    protected $table = 'trabajador';

    public function save(array $options = array())
    {
        $this->attributes['updated_by'] = $this->getUpdated();

       $val =  parent::save($options);

        \Event::fire(new TrabajadorWasSaved($this));

        return $val;
    }


    public function operaciones()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorOperacion');//,$foreingKey='id',$localKey='trabajador_id');
    }

    /*public function examenes_medicos()
    {
        return $this->hasMany('SSOLeica\Core\Model\TrabajadorOperacionExamMedico');
    }*/

    public function cargo()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreignKey= 'id',$localKey='cargo_id');//,$foreignKey= 'profesion_id',$localKey='id'
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
        return $this->app_paterno.' '.$this->app_materno .', '.$this->nombre;
    }

}
