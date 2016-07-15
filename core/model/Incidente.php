<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Traits\UpdatedBy;

class Incidente extends Model {

    use UpdatedBy,SoftDeletes;

    protected $table = 'incidente';

    protected $fillable = ['version','pais_id','contrato_id','tipo_informe_id','tipo_incidente_id','fecha','lugar','punto','equipos','parte','sector','responsable_id','tr_afectados','tr_involucrados','jornada_id','naturaleza','actividad','equipo','parte_equipo','producto','des_situacion','partes_afectas','entidad','consecuencia','dias_perdidos','cons_posibles','entidad_sini_mat','danios_mat','desc_danios_mat','entidad_sini_amb','lugar_danios_amb','desc_danios_amb','fotos','correlativo','register_by'];

    public function contrato()
    {
        return $this->hasOne('SSOLeica\Core\Model\Contrato',$foreingKey='id',$localKey='contrato_id');
    }

    public function tipo_informe()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreingKey='id',$localKey='tipo_informe_id');
    }

    public function tipo_incidente()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreingKey='id',$localKey='tipo_incidente_id');
    }

    public function getAfectadosAttribute(){

        $data = array();
        $query = "select t.dni,(t.nombre || ' ' || t.app_paterno || ' '||t.app_materno) as trabajador,c.name as cargo, t.fecha_ingreso, ct.inicio::date as fecha_cargo, ct.trabajador_id ";
        $query .= "from cargos_trabajador ct ";
        $query .= "inner join trabajador t on ct.trabajador_id = t.id ";
        $query .= "inner join enum_tables c on ct.cargo_id = c.id ";
        $query .= "where inicio <= :fecha and trabajador_id = :trabajador_id ";
        $query .= "order by inicio desc limit 1";

        if(!is_null($this->tr_afectados))
        {
            $afectados = json_decode($this->tr_afectados);

            foreach($afectados as $afectado)
            {
                $row = DB::select(DB::Raw($query),array('fecha' => $this->fecha, 'trabajador_id'=>$afectado));

                if(!is_null($row))
                    $data[] = $row[0];
            }
        }

        return $data;
    }

    public function getInvolucradosAttribute(){

        $data = array();
        $query = "select t.dni,(t.nombre || ' ' || t.app_paterno || ' '||t.app_materno) as trabajador,c.name as cargo, t.fecha_ingreso, ct.inicio::date as fecha_cargo, ct.trabajador_id ";
        $query .= "from cargos_trabajador ct ";
        $query .= "inner join trabajador t on ct.trabajador_id = t.id ";
        $query .= "inner join enum_tables c on ct.cargo_id = c.id ";
        $query .= "where inicio <= :fecha and trabajador_id = :trabajador_id ";
        $query .= "order by inicio desc limit 1";

        if(!is_null($this->tr_involucrados))
        {
            $afectados = json_decode($this->tr_involucrados);

            foreach($afectados as $involucrado)
            {
                $data[] = DB::select(DB::Raw($query),array('fecha' => $this->fecha, 'trabajador_id'=>$involucrado))[0];
            }


        }

        return $data;
    }

    public function getFotosAttribute()
    {
        $fotos = IncidenteFotos::where('incidente_id',$this->id)->get();

        //dd($fotos);

        $images = array();

        foreach($fotos as $foto )
        {
            $attr = array();

            if(!is_null($foto->attributes['attributes'])) {
                $attributes = json_decode($foto->attributes['attributes']);
                $attr['fullPath'] = $attributes->fullPath;
                $attr['fullPathTumb'] = $attributes->fullPathTumb;
            }
            else{
                $attr['fullPath'] = $foto->directorio.$foto->archivo;
                $attr['fullPathTumb'] = $foto->directorio.'tumb/'.$foto->archivo;
            }

            $images[]= array('id'=>$foto->id,
                             'incidente_id'=>$foto->incidente_id,
                             'archivo'=>$foto->archivo,
                             'directorio' => $foto->directorio,
                             'fullPath' => $attr['fullPath'],
                             'fullPathTumb' => $attr['fullPathTumb']
                         );
        }

        return (object)$images;
    }
}
