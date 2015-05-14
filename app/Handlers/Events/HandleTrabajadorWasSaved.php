<?php namespace SSOLeica\Handlers\Events;

use SSOLeica\Core\Model\CargosTrabajador;
use SSOLeica\Events\TrabajadorWasSaved;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class HandleTrabajadorWasSaved {

    /**
     * @var
     */
    protected $trabajador;

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
	 * @param  TrabajadorWasSaved  $event
	 * @return void
	 */
	public function handle(TrabajadorWasSaved $event)
	{
		$this->trabajador = $event->trabajador;

        $this->addCartoTrabajador();
	}

    private function addCartoTrabajador()
    {
        $old_cargo = CargosTrabajador::where('trabajador_id','=',$this->trabajador->id)
                        ->orderBy('updated_at','Desc')->first();

        if(!$old_cargo)
        {
            $this->saveCargo();
        }
        else if($old_cargo->cargo_id != $this->trabajador->cargo_id)
        {
            $this->saveCargo();
        }
    }

    private function saveCargo()
    {
        $cargo = new CargosTrabajador;
        $cargo->trabajador_id = $this->trabajador->id;
        $cargo->cargo_id = $this->trabajador->cargo_id;

        $cargo->save();
    }

}
