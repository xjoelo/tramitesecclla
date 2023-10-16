<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumeracionDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numeracion_documentos', function (Blueprint $table) {
            $table->id();

            $table->integer('tipoNumeracion')->nullable();// 1 => DOCUMENTO , 2 => EXPEDIENTE
            $table->integer('tipoOrigenDocumento')->nullable(); // 0 => interno, 1 => Externo 
            $table->string('prev',1)->nullable(); // I - INTERNO , E - INTERNO
            $table->bigInteger('numero')->nullable();

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
        Schema::dropIfExists('numeracion_documentos');
    }
}
