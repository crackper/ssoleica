<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class Operacion extends Model {

    use UpdatedBy;

    protected $table = 'operacion';

    public function contratos()
    {
        return $this->hasMany('SSOLeica\Core\Model\Contrato');//,$foreingKey='id',$localKey='trabajador_id');
    }

    public function getSiglasAttribute()
    {
        $data = "";

        if(array_key_exists('attributes', $this->attributes) && !is_null($this->attributes['attributes']))
        {
            $json = json_decode($this->attributes['attributes']);
            $data = $json[0];
        }

        return $data;
    }

    public function setSiglasAttribute($val)
    {
        $data[] = strtoupper($val);

        $this->attributes['attributes'] = json_encode($data);
    }
}
