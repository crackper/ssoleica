<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class HorasHombre extends Model {

    protected $table = 'horas_hombre';

    protected $fillable = ['month_id', 'contrato_id', 'fecha_inicio','fecha_fin','isOpen'];

    public function detalle_horas()
    {
        return $this->hasMany('SSOLeica\Core\Model\DetalleHorasHombre');//,$foreingKey='id',$localKey='trabajador_id');
    }

    public function mes()
    {
        return $this->hasOne('SSOLeica\Core\Model\Month',$foreingKey='id',$localKey='month_id');
    }

    public function contrato()
    {
        return $this->hasOne('SSOLeica\Core\Model\Contrato',$foreingKey='id',$localKey='contrato_id');
    }

}
