<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 24/04/15
 * Time: 12:59 PM
 */

namespace SSOLeica\Core\Repository;


use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Model\Trabajador;
use SSOLeica\Core\Data\Repository;
use SSOLeica\Core\Model\TrabajadorContrato;

class TrabajadorRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'SSOLeica\Core\Model\Trabajador';
    }

    function getTrabajadores()
    {
        $query = Trabajador::join('enum_tables','trabajador.cargo_id','=','enum_tables.id')
            ->select('trabajador.*')
            ->addSelect('enum_tables.name as cargo')
            ->addSelect(DB::raw('CONCAT(trabajador.app_paterno," " ,trabajador.app_materno ,", ", trabajador.nombre) AS full_name'));

        return $query;
    }

   function getTrabajadoresList($pais_id)
    {
        $query = Trabajador::where('pais_id','=',$pais_id)
            ->select('trabajador.id','trabajador.nombre','trabajador.app_paterno','trabajador.app_materno')
            //->addSelect(DB::raw('CONCAT(trabajador.nombre," ",trabajador.app_paterno," " ,trabajador.app_materno) AS full_name'))
            ->orderBy('trabajador.nombre')
            ->get();

        return $query;
    }

    /**
     * @param $trabajador_id
     * @return mixed
     */
    function getContratos($trabajador_id){
        return TrabajadorContrato::where('trabajador_id', '=', $trabajador_id)
            ->get()->load('contrato.operacion');
    }

    /**
     * @param $trabajador_id
     * @param $contrato_id
     * @return mixed
     */
    public  function updateContrato($contrato_id,$data = array(),$fechaFin = null)
    {
        $contrato = TrabajadorContrato::where('id','=',$contrato_id);

        if(!$fechaFin)
        {
            $success = $contrato->update($data);
        }
        else
        {
            $success = $contrato->update($data);
        }

        return $success;
    }

    function getTrabajadoresListAC($criterio,$pais_id)
    {
        $query = Trabajador::where('pais_id','=',$pais_id);

        $query = $query->where('nombre','like',$criterio.'%')
                    ->orWhere('app_paterno','like',$criterio.'%')
                    ->take(10)->get();

        return $query;
    }


}