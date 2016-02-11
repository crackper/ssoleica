<?php namespace SSOLeica\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use SSOLeica\Core\Model\EnumTables;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\DB;

class CerrarEstdSeguridad extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cerrar:estadisticas';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cierra Estadisticas de Seguridad';

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
        $this->info("Cerrando Estadisticas de Seguridad");
        $this->info("----------------------------------");

        $paises = EnumTables::where("type",'Pais')->get();

        $updated_by = json_encode(array('id' => 0,
            'name'=>'cerrar:estadisticas',
            'email'=>'',
            'trabjador_id'=> 0,
            'updated_at'=> new \DateTime() ));

        foreach($paises as $pais)
        {
            $this->info( Carbon::now(). " - cerrando: ".$pais->name);
            $data = json_decode($pais->data);

            $query = 'update estadistica_seguridad set "isOpen" = false, updated_at = :now, ';
            $query .= "updated_by = :updated_by ";
            $query .= "where id in (select es.id from estadistica_seguridad es ";
            $query .= "inner join contrato c on es.contrato_id = c.id ";
            $query .= "inner join operacion o on c.operacion_id = o.id ";
            $query .= "where o.pais_id = :id and now() at time zone 'utc' at time zone '". $data->timezone ."' >= es.fecha_fin and ".'"isOpen" = true)';

            $rows = DB::statement(DB::Raw($query),array('id' => $pais->id,'updated_by' => $updated_by, 'now' => new \DateTime()));

            $this->info($rows == 1 ? "OK": "NOK");
        }

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
