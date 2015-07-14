<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class EstadisticaSeguridad extends Model {

    protected $table = 'estadistica_seguridad';

    protected $fillable = ['month_id', 'contrato_id', 'fecha_inicio','fecha_fin','isOpen','conProrroga','dotacion','dias_perdidos','inc_stp','inc_ctp','attributes','updated_by'];

    public function mes()
    {
        return $this->hasOne('SSOLeica\Core\Model\Month',$foreingKey='id',$localKey='month_id');
    }

    public function contrato()
    {
        return $this->hasOne('SSOLeica\Core\Model\Contrato',$foreingKey='id',$localKey='contrato_id');
    }
}
