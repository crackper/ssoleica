<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 26/06/15
 * Time: 8:26 AM
 */

namespace SSOLeica\Core\Repository;


use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Data\Repository;
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

    public function registrar($month_id,$contrato_id,$trabajadores,$horas)
    {
        $success = 0;

        try
        {
            DB::connection()->getPdo()->beginTransaction();

            $data['month_id'] = $month_id;
            $data['contrato_id'] = $contrato_id;

            $month = Month::find($month_id);

            $data['fecha_inicio'] = new \DateTime($month->fecha_inicio);

            $fechaFin = new \DateTime($month->fecha_fin);
            $data['fecha_fin'] = $fechaFin->add(new \DateInterval('P'.$month->plazo.'D'));

            $horasHombre = HorasHombre::create($data);

            $detalle = array();
            $total = 0;

            for($i = 0; $i < count($trabajadores); $i++){
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
}