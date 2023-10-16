<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumeracionTipoDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numeracion_tipo_documentos', function (Blueprint $table) {
            $table->id();

            $table->integer('idTipoDocumento')->nullable();
            $table->integer('idDependencia')->nullable();
            $table->integer('idUsuario')->nullable();
            $table->string('periodo',4)->nullable();
            $table->integer('numero')->nullable();

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
        Schema::dropIfExists('numeracion_tipo_documentos');
    }
}
