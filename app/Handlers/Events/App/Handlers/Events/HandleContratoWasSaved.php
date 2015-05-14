<?php namespace SSOLeica\Handlers\Events\App\Handlers\Events;

use SSOLeica\Events\App\Events\ContratoWasSaved;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class HandleContratoWasSaved {

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
		//
	}

}
