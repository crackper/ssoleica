<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SSOLeica\Core\Traits\UpdatedBy;
use SSOLeica\Events\TrabajadorWasSaved;

class Trabajador extends Model {

    use UpdatedBy,SoftDeletes;

    protected $table = 'trabajador';

    protected $data =array();

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

    public function getFullName1Attribute(){
        return $this->nombre.' '. $this->app_paterno.' '.$this->app_materno;
    }

    protected function updateAttributes($val,$pos)
    {
        $data = json_decode($this->attributes['attributes']);

        $data[$pos-1] = strtoupper($val);

        $this->attributes['attributes'] = json_encode($data);
    }

    protected function  getAttr($pos){
        $data = "";

        if(array_key_exists('attributes', $this->attributes) && !is_null($this->attributes['attributes']))
        {
            $json = json_decode($this->attributes['attributes']);

            count($json) >= $pos  ? $data = $json[$pos-1]: "";
        }

        return $data;
    }

    public function getEnfermedadesAttribute()
    {
       return $this->getAttr(1);
    }

    public function setEnfermedadesAttribute($val)
    {
        $this->updateAttributes($val,1);
    }

    public function getMedicamentosAttribute()
    {
        return $this->getAttr(2);
    }

    public function setMedicamentosAttribute($val)
    {

        $this->updateAttributes($val,2);
    }

    public function getAlergiasAttribute()
    {
        return $this->getAttr(3);
    }

    public function setAlergiasAttribute($val)
    {
        $this->updateAttributes($val,3);
    }

    public function getAccidentesAttribute()
    {
        return $this->getAttr(4);
    }

    public function setAccidentesAttribute($val)
    {
        $this->updateAttributes($val,4);
    }

    public function getTCamisaAttribute()
    {
        return $this->getAttr(5);
    }

    public function setTCamisaAttribute($val)
    {
        $this->updateAttributes($val,5);
    }

    public function getTZapatosAttribute()
    {
        return $this->getAttr(6);
    }

    public function setTZapatosAttribute($val)
    {
        $this->updateAttributes($val,6);
    }

    public function getTPoloAttribute()
    {
        return $this->getAttr(7);
    }

    public function setTPoloAttribute($val)
    {
        $this->updateAttributes($val,7);
    }

    public function getTGuantesAttribute()
    {
        return $this->getAttr(8);
    }

    public function setTGuantesAttribute($val)
    {
        $this->updateAttributes($val,8);
    }

    public function getTRespiradorAttribute()
    {
        return $this->getAttr(9);
    }

    public function setTRespiradorAttribute($val)
    {
        $this->updateAttributes($val,9);
    }

    public function getTCasacaAttribute()
    {
        return $this->getAttr(10);
    }

    public function setTCasacaAttribute($val)
    {
        $this->updateAttributes($val,10);
    }

    public function getTChalecoAttribute()
    {
        return $this->getAttr(11);
    }

    public function setTChalecoAttribute($val)
    {
        $this->updateAttributes($val,11);
    }

    public function getTPantalonAttribute()
    {
        return $this->getAttr(12);
    }

    public function setTPantalonAttribute($val)
    {
        $this->updateAttributes($val,12);
    }

}
