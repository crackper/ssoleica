<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class IncidenteMedidasSeguridad extends Model {

    use UpdatedBy,SoftDeletes;

    protected $table = 'incidente_medidas_seguridad';

}
