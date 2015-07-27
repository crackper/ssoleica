<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class ShiftContratoTrabajador extends Model {

    use UpdatedBy;

	protected $table = 'shift_contrato_trabajador';

}
