<?php namespace SSOLeica\Handlers\Events;

use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Model\EstadosContrato;
use SSOLeica\Events\ContratoWasSaved;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class HandleContratoWasSaved {

    /**
     * @var
     */
    protected  $contrato;

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  ContratoWasSaved  $event
	 * @return void
	 */
	public function handle(ContratoWasSaved $event)
	{

        //\Log::info(print_r('HandleContratoWasSaved', true));

        $this->contrato= $event->contrato;

        $this->addEstadoContrato();
	}

    private function addEstadoContrato()
    {
        $old_estate = EstadosContrato::where('contrato_id','=',$this->contrato->id)
                        ->orderBy('updated_at','Desc')->first();

        if(!$old_estate)
        {
            $this->saveState();
        }
        else if($old_estate->supervisor_id != $this->contrato->supervisor_id || $old_estate->asesor_prev_riesgos_id != $this->contrato->asesor_prev_riesgos_id || $old_estate->exist_cphs != $this->contrato->exist_cphs || $old_estate->exist_subcontrato != $this->contrato->exist_subcontrato)
        {
            $this->saveState();
        }

        //\Log::info(print_r('nuevo estado para el contrato: '.$this->contrato->contrado_id, true));
    }

    private function saveState()
    {
        $estado = new EstadosContrato;
        $estado->contrato_id = $this->contrato->id;
        $estado->supervisor_id = $this->contrato->supervisor_id;
        $estado->asesor_prev_riesgos_id = $this->contrato->asesor_prev_riesgos_id;
        $estado->exist_cphs = $this->contrato->exist_cphs;
        $estado->exist_subcontrato = $this->contrato->exist_subcontrato;

        $estado->save();
    }

}
