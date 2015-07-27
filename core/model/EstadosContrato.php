<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class EstadosContrato extends Model {

    use UpdatedBy;

    protected $table = 'estados_contrato';
}
