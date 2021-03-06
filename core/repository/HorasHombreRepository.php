<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 26/06/15
 * Time: 8:26 AM
 */

namespace SSOLeica\Core\Repository;


use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Helpers\Timezone;
use SSOLeica\Core\Model\DetalleHorasHombre;
use SSOLeica\Core\Model\HorasHombre;
use SSOLeica\Core\Model\Month;

class HorasHombreRepository extends Repository{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\HorasHombre';
    }

    public function registrar($month_id,$contrato_id,$trabajadores,$horas,$timezone)
    {
        $success = 0;

        try
        {
            DB::connection()->getPdo()->beginTransaction();

            $data['month_id'] = $month_id;
            $data['contrato_id'] = $contrato_id;

            $month = Month::find($month_id);

            $data['fecha_inicio'] =  Timezone::toUTC($month->fecha_inicio,$timezone);

            $fechaFin = Timezone::toUTC($month->fecha_fin,$timezone);

            $data['fecha_fin'] = Timezone::addTime($fechaFin,'P'.$month->plazo.'D');

            $horasHombre = HorasHombre::create($data);

            $detalle = array();
            $total = 0;

            for($i = 0; $i < count($trabajadores); $i++)
            {
                $detalle['horas_hombre_id'] = $horasHombre->id;
                $detalle['trabajador_id'] = $trabajadores[$i];
                $detalle['horas'] = $horas[$i];

                DetalleHorasHombre::create($detalle);
                $total += $horas[$i];
            }

            HorasHombre::where('id','=',$horasHombre->id)->update(array('total'=>$total));

            DB::connection()->getPdo()->commit();
            $success = 1;
        }
        catch(\PDOException $ex)
        {
            DB::connection()->getPdo()->rollback();
            Log::error('Error al registrar Horas Hombre: '. $ex);
            $success = 0;
        }

        $msg["success"] = $success;
        $msg["id"] = $horasHombre->id;
        $msg["horasHombre"] = $horasHombre;

        return $msg;
    }


    public function actualizar($horas_hombre_id,$detalles, $trabajadores,$horas)
    {
        $success = 0;

        try
        {
            DB::connection()->getPdo()->beginTransaction();

            $detalle = array();
            $total = 0;

            for($i = 0; $i < count($trabajadores); $i++)
            {
                $detalle['horas_hombre_id'] = $horas_hombre_id;
                $detalle['trabajador_id'] = $trabajadores[$i];
                $detalle['horas'] = $horas[$i];

                if($detalles[$i] == 0)
                {
                    $d = DetalleHorasHombre::create($detalle);
                }
                else
                {
                    DetalleHorasHombre::where('id',$detalles[$i])->update(array('horas'=>$horas[$i]));
                }


                $total += $horas[$i];
            }

            HorasHombre::where('id','=',$horas_hombre_id)->update(array('total'=>$total));

            DB::connection()->getPdo()->commit();
            $success = 1;
        }
        catch(\PDOException $ex)
        {
            DB::connection()->getPdo()->rollback();
            Log::error('Error al actualizar Horas Hombre: '. $ex);

            //dd($ex);
            $success = 0;
        }

        $msg["success"] = $success;
        $msg["id"] = $horas_hombre_id;

        return $msg;
    }

    public function getQueryHorasHombre($pais_id)
    {
        $query = HorasHombre::join('contrato','contrato.id','=','horas_hombre.contrato_id')
            ->join('month','month.id','=','horas_hombre.month_id')
            ->join('operacion','operacion.id','=','contrato.operacion_id')
            ->where('operacion.pais_id',$pais_id)
            ->select('horas_hombre.*')
            ->addSelect('operacion.nombre_operacion as proyecto')
            ->addSelect('contrato.nombre_contrato as contrato')
            ->addSelect('month.year')
            ->addSelect('month.nombre as mes');
        //->orderBy('month.id','desc')
        //->orderBy('month.year','desc');

        return $query;
    }

    public function getHeadHorasHombre($id)
    {
        $horasHombre = HorasHombre::where('id','=',$id)->get()
            ->load('contrato.operacion')
            ->load('mes')
            ->first();

        return $horasHombre;
    }

    public function getDetalleHorasHombre($horas_hombre_id,$timezone)
    {
        $query = "select case when dhh.id is null then 0 else dhh.id end as id,";
        $query .= "case when hh.id is null then 0 else hh.id end as horas_hombre_id,";
        $query .= "t.id as trabajador_id,";
        $query .= "(t.app_paterno || t.app_materno || ', ' || t.nombre) as trabajador,c.name as cargo,";
        $query .= "case when dhh.horas is null then 0 else dhh.horas::integer end as horas, ";
        $query .= "case when tc.fecha_inicio between (m.fecha_inicio at time zone 'UTC' at time zone '". $timezone ."') and m.fecha_fin ";//inicio
        $query .= "then ";
        $query .= "case when tc.fecha_inicio at time zone 'UTC' = m.fecha_inicio then cc.jorn_max_trabajador ";
        $query .= "when date_part('day',m.fecha_fin  - tc.fecha_inicio at time zone 'UTC' at time zone '". $timezone ."' ) > 20 then cc.jorn_max_trabajador ";
        $query .= "else  ";
        $query .= "cc.hrs_max_dia  * (date_part('day',m.fecha_fin  - tc.fecha_inicio at time zone 'UTC' at time zone '". $timezone ."' )+1) end ";
        $query .= "else cc.jorn_max_trabajador end as jorn_max_trabajador ";//fin
        $query .= "from trabajador_contrato tc ";
        $query .= "left join trabajador t on tc.trabajador_id = t.id ";
        $query .= "left join enum_tables c on t.cargo_id = c.id ";
        $query .= "left join horas_hombre hh on tc.contrato_id = hh.contrato_id ";
        $query .= "left join detalle_horas_hombre dhh on hh.id = dhh.horas_hombre_id and t.id = dhh.trabajador_id ";
        $query .= "left join month m on hh.month_id = m.id ";
        $query .= "left join contrato cc on tc.contrato_id = cc.id ";
        $query .= "where hh.id = :id and tc.is_activo = true order by app_paterno";

        $trabajadores = DB::select(DB::Raw($query),array('id' => $horas_hombre_id));

        return $trabajadores;
    }

     public function getDetalleHoras($timezone,$mes_id,$contrato_id)
    {
        $query = "select tc.trabajador_id,(t.nombre || t.app_paterno || t.app_materno) as trabajador ,cr.name as cargo,";
        $query .= "tc.fecha_inicio  at time zone 'UTC' at time zone '". $timezone ."' as inicio_contrato,";
        $query .= "case when tc.fecha_inicio between (m.fecha_inicio at time zone 'UTC' at time zone '". $timezone ."') and m.fecha_fin ";
        $query .= "then ";
        $query .= "case when tc.fecha_inicio at time zone 'UTC' = m.fecha_inicio then c.jorn_max_trabajador ";
        $query .= "when date_part('day',m.fecha_fin  - tc.fecha_inicio at time zone 'UTC' at time zone '". $timezone ."' ) > 20 then c.jorn_max_trabajador ";
        $query .= "else  ";
        $query .= "c.hrs_max_dia  * (date_part('day',m.fecha_fin  - tc.fecha_inicio at time zone 'UTC' at time zone '". $timezone ."' )+1) end ";
        $query .= "else c.jorn_max_trabajador end as jorn_max_trabajador ";
        $query .= "from trabajador_contrato tc  ";
        $query .= "inner join contrato c on tc.contrato_id = c.id ";
        $query .= "inner join trabajador t on tc.trabajador_id = t.id ";
        $query .= "inner join enum_tables cr on t.cargo_id = cr.id ";
        $query .= "inner join month m on m.id = :mes_id ";
        $query .= "where t.deleted_at is null and  tc.contrato_id = :contrato_id and tc.is_activo = '1'";

        $trabajadores = DB::select(DB::Raw($query),array('mes_id' => $mes_id,'contrato_id' => $contrato_id));

        return $trabajadores;
    }
}
