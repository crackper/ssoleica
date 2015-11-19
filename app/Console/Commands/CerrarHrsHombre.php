<?php namespace SSOLeica\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use SSOLeica\Core\Model\EnumTables;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\DB;

class CerrarHrsHombre extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:cerrarhh';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info("Cerrando Horas Hombre");
        $this->info("-----------------------------");

        $paises = EnumTables::where("type",'Pais')->get();

        $updated_by = json_encode(array('id' => 0,
            'name'=>'comand:cerrarhh',
            'email'=>'',
            'trabjador_id'=> 0,
            'updated_at'=> new \DateTime() ));

        foreach($paises as $pais)
        {
            $this->info( Carbon::now(). " - cerrando: ".$pais->name);
            $data = json_decode($pais->data);

            $query = 'update horas_hombre set "isOpen" = false, updated_at = :now, ';
            $query .= "updated_by = :updated_by ";
            $query .= "where id in (select hh.id from horas_hombre hh ";
            $query .= "inner join contrato c on hh.contrato_id = c.id ";
            $query .= "inner join operacion o on c.operacion_id = o.id ";
            $query .= "where o.pais_id = :id and now() at time zone 'utc' at time zone '". $data->timezone ."' >= hh.fecha_fin and ".'"isOpen" = true)';

            $rows = DB::statement(DB::Raw($query),array('id' => $pais->id,'updated_by' => $updated_by, 'now' => new \DateTime()));

            $this->info($rows == 1 ? "OK": "NOK");
        }

        /*Mail::send('emails.password', ['token' => '324242423234'], function($message)
        {
            $message->to('samuel.mestanza@hotmail.com', 'John Smith')
                ->cc("Samuel.Alcantara@hexagonmining.com","Samuel Mestanza")
                ->subject('Welcome!');
        });*/
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			//['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			//['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
