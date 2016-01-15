<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class IncidenteFotos extends Model {

    use UpdatedBy;

    protected $table = 'incidente_foto';

}
