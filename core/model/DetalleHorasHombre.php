<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class DetalleHorasHombre extends Model {

    protected $table = 'detalle_horas_hombre';

    protected $fillable = ['horas_hombre_id', 'trabajador_id', 'horas','extra'];
}
