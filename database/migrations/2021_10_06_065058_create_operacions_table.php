<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operacions', function (Blueprint $table) {
            $table->id();

            $table->integer('idDocumento')->nullable();
            $table->integer('nroDocumento')->nullable();

            /*================ORIGEN==================*/
            $table->integer('idDependencia')->nullable();
            $table->integer('iduser')->nullable();

            $table->dateTime('fechaOperacion')->nullable();
            $table->integer('tipoOperacion')->nullable();//1 => Registrado , 2 => Derivado ,3 => Archivado ,4 => Adjuntado'
            $table->integer('forma')->nullable();// 1 => Orginal ,  0 => Copia

            /*================ DESTINO================*/
            $table->integer('idDependenciaDestino')->nullable();
            $table->integer('iduserDestino')->nullable();

            $table->text('proveido')->nullable();//ACIONES tu atencioan

            $table->integer('idProcesado')->nullable();
            $table->integer('idDocumentoAdjunto')->nullable();
            $table->boolean('isProcesado')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operacions');
    }
}
