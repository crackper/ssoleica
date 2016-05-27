<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Traits\UpdatedBy;

class IncidenteMedidasSeguridad extends Model {

    use UpdatedBy,SoftDeletes;

    protected $fillable =['incidente_id','type','accion','fecha_comprometida','responsables','attr'];

    protected $table = 'incidente_medidas_seguridad';

    public function getResponsablesLblAttribute(){

        $resp = json_decode($this->responsables);

        $trabajadores = Trabajador::whereIn('id',$resp)->get();

        $lbl = "";

        foreach($trabajadores as $key=>$row)
        {
            $coma = $key+1 != count($trabajadores) ? ", ": "";
            $lbl .= $row->nombre." ". $row->app_paterno.$coma;
        }

        return $lbl;
    }

}
