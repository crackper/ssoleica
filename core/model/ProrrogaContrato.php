<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class ProrrogaContrato extends Model {

    use UpdatedBy;

    protected $table = 'prorroga_contrato';

    public function solicita()
    {
        return $this->hasOne('SSOLeica\Core\Model\Trabajador',$foreingKey='id',$localKey='solicita_id');
    }

    public function aprueba()
    {
        return $this->hasOne('SSOLeica\Core\Model\Trabajador',$foreingKey='id',$localKey='aprueba_id');
    }

    public function mes()
    {
        return $this->hasOne('SSOLeica\Core\Model\Month',$foreingKey='id',$localKey='month_id');
    }
}
