<?php namespace SSOLeica\Events\App\Events;

use SSOLeica\Events\Event;

use Illuminate\Queue\SerializesModels;

class ContratoWasSaved extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

}
