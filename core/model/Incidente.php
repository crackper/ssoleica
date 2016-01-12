<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class Incidente extends Model {

    use UpdatedBy;

    protected $table = 'incidente';

    protected $fillable = ['version','pais_id','contrato_id','tipo_informe_id','tipo_incidente_id','fecha','lugar','punto','equipos','parte','sector','responsable_id','tr_afectados','tr_involucrados','jornada_id','naturaleza','actividad','equipo','parte_equipo','producto','des_situacion','partes_afectas','entidad','consecuencia','dias_perdidos','cons_posibles','entidad_sini_mat','danios_mat','desc_danios_mat','entidad_sini_amb','lugar_danios_amb','desc_danios_amb','fotos'];

}
