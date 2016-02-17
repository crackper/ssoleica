<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 16/02/16
 * Time: 9:04 AM
 */

namespace SSOLeica\Core\Repository;

use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\ProrrogaContrato;

class ProrrogaContratoRepository extends Repository{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\ProrrogaContrato';
    }

    public function getProrrogasContrato($contrato_id = 0)
    {
        $query = ProrrogaContrato::join('trabajador as s','prorroga_contrato.solicita_id','=','s.id')
            ->leftJoin('trabajador as a','prorroga_contrato.aprueba_id','=','a.id')
            ->leftJoin('month as m','prorroga_contrato.month_id','=','m.id')
            ->leftJoin('contrato as c','prorroga_contrato.contrato_id','=','c.id')
            ->where('prorroga_contrato.aprobado',true)
            ->where('c.id',$contrato_id)
            ->select('prorroga_contrato.*')
            ->addSelect(DB::raw("(s.nombre || ' ' || s.app_paterno) AS solicita"))
            ->addSelect(DB::raw("(a.nombre || ' ' || a.app_paterno) AS aprueba"))
            ->addSelect('m.nombre as mes')
            ->addSelect('c.nombre_contrato as contrato');

        return $query;

    }

    public function getProrrogasPendientes()
    {
        $query = ProrrogaContrato::join('trabajador as s','prorroga_contrato.solicita_id','=','s.id')
            ->leftJoin('trabajador as a','prorroga_contrato.aprueba_id','=','a.id')
            ->leftJoin('month as m','prorroga_contrato.month_id','=','m.id')
            ->leftJoin('contrato as c','prorroga_contrato.contrato_id','=','c.id')
            ->where('prorroga_contrato.aprobado',false)
            ->select('prorroga_contrato.*')
            ->addSelect(DB::raw("(s.nombre || ' ' || s.app_paterno) AS solicita"))
            ->addSelect(DB::raw("(a.nombre || ' ' || a.app_paterno) AS aprueba"))
            ->addSelect('m.nombre as mes')
            ->addSelect('c.nombre_contrato as contrato');

        return $query;

    }
}

?>