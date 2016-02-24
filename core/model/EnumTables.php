<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SSOLeica\Core\Traits\UpdatedBy;

class EnumTables extends Model {

    use UpdatedBy,SoftDeletes;

	protected $table = 'enum_tables';

    /*public function trabajadores()
    {
        return $this->hasMany('SSOLeica\Core\Model\Trabajador',$foreignKey = 'profesion_id',$localKey='id');
    }*/

    public function categorias()
    {
        return $this->hasMany('SSOLeica\Core\Model\EnumCategories',$foreignKey = 'category_id',$localKey='id');
    }

    public function getDataStringAttribute()
    {
        $data = "";

        if(!is_null($this->data))
        {
            $json = json_decode($this->data);
            $data = implode(',',$json);
        }

        return $data;
    }

    public function setDataStringAttribute($val)
    {
        $data = null;

        if(!is_null($val) && $val != "")
        {
            $data = json_encode(explode(',',$val));
        }
        $this->data = $data;
    }

    public function getTypeLabelAttribute()
    {
        return $this->type;
    }

}
