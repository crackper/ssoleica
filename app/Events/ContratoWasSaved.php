<?php namespace SSOLeica\Events;

use SSOLeica\Events\Event;

use Illuminate\Queue\SerializesModels;

class ContratoWasSaved extends Event {

	use SerializesModels;


    /**
     * @var
     */
    public  $contrato;


    /**
     * @param $contrado
     */
    public function __construct($contrado)
	{
        $this->contrato= $contrado;

        //\Log::info(print_r('ContratoWasSaved', true));
    }

}
