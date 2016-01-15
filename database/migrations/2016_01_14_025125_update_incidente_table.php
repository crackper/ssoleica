<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIncidenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement(" ALTER TABLE incidente ALTER COLUMN lugar  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN fotos  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN equipos  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN parte  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN sector  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN tr_afectados  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN tr_involucrados  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN naturaleza  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN actividad  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN equipo  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN parte_equipo  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN producto  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN des_situacion  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN partes_afectas  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN entidad  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN consecuencia  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN dias_perdidos  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN entidad  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN consecuencia  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN dias_perdidos  SET DEFAULT 0");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN cons_posibles  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN entidad_sini_mat  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN danios_mat  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN desc_danios_mat  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN entidad_sini_amb  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN lugar_danios_amb  DROP  NOT NULL");
        DB::statement(" ALTER TABLE incidente ALTER COLUMN desc_danios_amb  DROP  NOT NULL");

        /*Schema::table('incidente',  function(Blueprint $table)
        {
            //general
            $table->string("lugar")->nullable()->change();
            $table->string("punto")->nullable()->change();
            $table->string("equipos")->nullable()->change();
            $table->string("parte")->nullable()->change();
            $table->string("sector")->nullable()->change();
            $table->text('tr_afectados')->nullable()->change();//
            $table->text('tr_involucrados')->nullable()->change();//
            //circunstancias
            $table->string('naturaleza')->nullable()->change();
            $table->string('actividad')->nullable()->change();
            $table->string('equipo')->nullable()->change();
            $table->string('parte_equipo')->nullable()->change();
            $table->string('producto')->nullable()->change();
            $table->text('des_situacion')->nullable()->change();
            //perdidas
            $table->text('partes_afectas')->nullable()->change();//
            $table->text('entidad')->nullable()->change();//
            $table->text('consecuencia')->nullable()->change();//
            $table->integer('dias_perdidos')->default(0)->change();
            $table->text('cons_posibles')->nullable()->change();
            //daños
            $table->text('entidad_sini_mat')->nullable()->change();//
            $table->text('danios_mat')->nullable()->change();
            $table->text('desc_danios_mat')->nullable()->change();
            $table->text('entidad_sini_amb')->nullable()->change();//
            $table->text('lugar_danios_amb')->nullable()->change();
            $table->text('desc_danios_amb')->nullable()->change();
            //fotografias
            $table->text('fotos');//
        });*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('incidente');
	}

}
