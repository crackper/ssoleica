<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class DetalleHorasHombre extends Model {

    use UpdatedBy;

    protected $table = 'detalle_horas_hombre';

    protected $fillable = ['id','horas_hombre_id', 'trabajador_id', 'horas','extra'];
}
