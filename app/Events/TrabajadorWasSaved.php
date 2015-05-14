<?php namespace SSOLeica\Events;

use SSOLeica\Events\Event;

use Illuminate\Queue\SerializesModels;

class TrabajadorWasSaved extends Event {

	use SerializesModels;
    /**
     * @var
     */
    public $trabajador;

    /**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($trabajador)
	{
        $this->trabajador = $trabajador;
        \Log::info(print_r('TrabajadorWasSaved', true));
    }

}
