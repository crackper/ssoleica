<?php namespace SSOLeica\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SSOLeica\Core\Model\EnumTables;
use SSOLeica\Core\Model\Operacion;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Mail;

class AlertasNextMes extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'alertas:nextmes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Envio de E-mails con alertas del proximo mes';

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
        $this->info("Enviando Alertas Próximo Mes");
        $this->info("-----------------------------");

        $paises = EnumTables::where("type",'Pais')->get();

        foreach($paises as $pais)
        {
            $this->info( Carbon::now(). " - Enviando Alertas: ".$pais->name);

            $proyectos = Operacion::where("pais_id",$pais->id)->get();

            $data_f = array();
            $data_e = array();
            $data_d = array();

            foreach($proyectos as $proyecto)
            {
                //fotochecks
                $query_f = "select p.name as  pais,o.nombre_operacion as operacion, (t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
                $query_f .= "tc.nro_fotocheck as fotocheck, ";
                $query_f .= "tc.fecha_vencimiento at time zone 'utc' at time zone (p.data->>'timezone')::text as fecha_vencimiento ";
                $query_f .= "from trabajador_contrato tc ";
                $query_f .= "inner join trabajador t on tc.trabajador_id = t.id ";
                $query_f .= "inner join contrato c on tc.contrato_id = c.id ";
                $query_f .= "inner join operacion o on c.operacion_id = o.id ";
                $query_f .= "inner join enum_tables p on o.pais_id = p.id ";
                $query_f .= "where (tc.fecha_vencimiento  between (DATE_TRUNC('month', nextmes()) at time zone 'utc') and  ((DATE_TRUNC('month', nextmes())  at time zone 'utc') + '1 month')) ";
                $query_f .= "and p.id = :pais_id and operacion_id = :operacion_id order by tc.fecha_vencimiento";

                $fotochecks = DB::select(DB::Raw($query_f),array('pais_id' => $pais->id,'operacion_id'=>$proyecto->id));

                if(count($fotochecks)>0)
                {
                    $proyecto["proyecto"] = $proyecto->nombre_operacion;
                    $proyecto["fotochecks"]= $fotochecks;
                    $data_f[]=$proyecto;

                    $this->info("Proyecto: " . $proyecto->nombre_operacion);
                    $this->info("Fotochecks: " . count($fotochecks));
                    $this->info("----------------------------------------");
                }
            }

            foreach($proyectos as $proyecto)
            {
                //examenes
                $query_e = "select p.name as  pais,o.nombre_operacion as operacion,v.type, ";
                $query_e .= "(t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
                $query_e .= "v.name as vencimiento, ";
                $query_e .= "tv.fecha_vencimiento at time zone 'utc' at time zone (p.data->>'timezone')::text as fecha_vencimiento ";
                $query_e .= "from trabajador_vencimiento tv ";
                $query_e .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
                $query_e .= "inner join trabajador t on tv.trabajador_id = t.id ";
                $query_e .= "inner join operacion o on tv.operacion_id = o.id ";
                $query_e .= "inner join enum_tables p on o.pais_id = p.id ";
                $query_e .= "where tv.caduca = true and v.type = 'ExamenMedico' ";
                $query_e .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', nextmes()) at time zone 'utc') and  ((DATE_TRUNC('month', nextmes())  at time zone 'utc') + '1 month')) ";
                $query_e .= "and p.id = :pais_id and o.id = :operacion_id ";
                $query_e .= "order by o.nombre_operacion,tv.fecha_vencimiento,t.app_paterno";

                $examenes = DB::select(DB::Raw($query_e),array('pais_id' => $pais->id,'operacion_id'=>$proyecto->id));

                if(count($examenes)>0)
                {
                    $proyecto_e["proyecto"] = $proyecto->nombre_operacion;
                    $proyecto_e["examenes"]= $examenes;
                    $data_e[]=$proyecto_e;

                    $this->info("Proyecto: " . $proyecto->nombre_operacion);
                    $this->info("Exámenes Médicos: " . count($examenes));
                    $this->info("----------------------------------------");
                }
            }

            //documentos
            $query_d = "select p.name as  pais,v.type, ";
            $query_d .= "(t.nombre ||' '|| t.app_paterno ||' '|| t.app_materno) as trabajador, ";
            $query_d .= "v.name as vencimiento, ";
            $query_d .= "tv.fecha_vencimiento at time zone 'utc' at time zone (p.data->>'timezone')::text as fecha_vencimiento ";
            $query_d .= "from trabajador_vencimiento tv ";
            $query_d .= "inner join enum_tables v on tv.vencimiento_id = v.id ";
            $query_d .= "inner join trabajador t on tv.trabajador_id = t.id ";
            $query_d .= "inner join enum_tables p on t.pais_id = p.id ";
            $query_d .= "where tv.caduca = true and v.type = 'Documento' ";
            $query_d .= "and (tv.fecha_vencimiento  between (DATE_TRUNC('month', nextmes()) at time zone 'utc') and  ((DATE_TRUNC('month', nextmes())  at time zone 'utc') + '1 month')) ";
            $query_d .= "and p.id = :pais_id ";
            $query_d .= "order by tv.fecha_vencimiento,t.app_paterno ";

            $documentos = DB::select(DB::Raw($query_d),array('pais_id' => $pais->id));

            if(count($documentos) > 0)
            {
                $proyecto_d["proyecto"] = "Otros Documentos";
                $proyecto_d["documentos"]= $documentos;
                $data_d[]=$proyecto_d;

                $this->info("Otros Documentos");
                $this->info("Documentos: " . count($documentos));
                $this->info("----------------------------------------");
            }

            if(count($data_f) > 0 || count($data_e) > 0 || count($data_d) > 0)
            {
                switch($pais->id)
                {
                    case 8: //peru

                        Mail::send('emails.alertas', ['pais'=>'Perú','subject'=>'Samuel','data_f'=>$data_f,'data_e'=>$data_e,'data_d'=>$data_d],
                            function($message)
                            {
                                $message->to('Samuel.Alcantara@hexagonmining.com', 'Samuel Mestanza')->subject('Documentos que vencen el próximo mes.');
                                $this->info("Correo enviado a: Samuel.Alcantara@hexagonmining.com");
                            });

                        Mail::send('emails.alertas', ['pais'=>'Perú','subject'=>'Marvick','data_f'=>$data_f,'data_e'=>$data_e,'data_d'=>$data_d],
                            function($message)
                            {
                                $message->to('Marvick.Aliaga@hexagonmining.com', 'Marvick Aliaga')->subject('Documentos que vencen el próximo mes.');
                                $this->info("Correo enviado a: Marvick.Aliaga@hexagonmining.com");
                            });

                        Mail::send('emails.alertas', ['pais'=>'Perú','subject'=>'Marilyn','data_f'=>$data_f,'data_e'=>$data_e,'data_d'=>$data_d],
                            function($message)
                            {
                                $message->to('Marilyn.Castillo@hexagonmining.com', 'Marilyn Castillo')->subject('Documentos que vencen el próximo mes.');
                                $this->info("Correo enviado a: Marilyn.Castillo@hexagonmining.com");
                            });

                        Mail::send('emails.alertas', ['pais'=>'Perú','subject'=>'Fredy','data_f'=>$data_f,'data_e'=>$data_e,'data_d'=>$data_d],
                            function($message)
                            {
                                $message->to('fredy.novoa@hexagonmining.com', 'Fredy Novoa')->subject('Documentos que vencen el próximo mes.');
                                $this->info("Correo enviado a: fredy.novoa@hexagonmining.com");
                            });

                        $this->info("----------------------------------------");

                        break;
                    case 9: //chile

                        Mail::send('emails.alertas', ['pais'=>'Chile','subject'=>'Samuel','data_f'=>$data_f,'data_e'=>$data_e,'data_d'=>$data_d],
                            function($message)
                            {
                                $message->to('Samuel.Alcantara@hexagonmining.com', 'Samuel Mestanza')->subject('Documentos que vencen el próximo mes.');
                                $this->info("Correo enviado a: Samuel.Alcantara@hexagonmining.com");
                            });

                        Mail::send('emails.alertas', ['pais'=>'Chile','subject'=>'José','data_f'=>$data_f,'data_e'=>$data_e,'data_d'=>$data_d],
                            function($message)
                            {
                                $message->to('jose.arevalo@hexagonmining.com', 'José Arévalo')->subject('Documentos que vencen el próximo mes.');
                                $this->info("Correo enviado a: jose.arevalo@hexagonmining.com");
                            });

                        Mail::send('emails.alertas', ['pais'=>'Chile','subject'=>'Patricio','data_f'=>$data_f,'data_e'=>$data_e,'data_d'=>$data_d],
                            function($message)
                            {
                                $message->to('patricio.romero@hexagonmining.com', 'Patricio Romero')->subject('Documentos que vencen este mes.');
                                $this->info("Correo enviado a: patricio.romero@hexagonmining.com");
                            });

                        Mail::send('emails.alertas', ['pais'=>'Chile','subject'=>'Carlos','data_f'=>$data_f,'data_e'=>$data_e,'data_d'=>$data_d],
                            function($message)
                            {
                                $message->to('carlos.daza@hexagonmining.com', 'Carlos Daza')->subject('Documentos que vencen el próximo mes.');
                                $this->info("Correo enviado a: Carlos.Daza@hexagonmining.com");
                            });

                        $this->info("----------------------------------------");

                        break;
                }

            }
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