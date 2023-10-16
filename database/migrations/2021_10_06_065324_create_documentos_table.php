<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
          $table->id();
          /* ==================== DATOS DE  DOCUMENTO ======================= */
          $table->string('nroDocumento')->nullable();
          $table->string('nroExpediente')->nullable(); // null
          $table->integer('idTipoDocumento')->nullable();
          $table->string('nroDocumentoTipo',10)->nullable(); // table documento tipo
          $table->string('siglas',50)->nullable();
          $table->boolean('origenDocumento')->default(0);# 0 => interno, 1 => Externo
          $table->integer('urgencia')->default(1); # 1 => Normail , 2 => Urgente , 3 => muy Urgente
          $table->string('folios',10)->nullable();
          $table->text('asunto')->nullable();
          $table->date('fechaDocumento')->nullable();
          $table->dateTime('fechaRegistro')->nullable();

          /*===================DATOS DE DEPENDENCIA Y PERSONA=================== */
          $table->integer('tipoPersona')->nullable(); # 1 => PERSONA NATURAL ,  2 => PERSONA JURIDICA
          $table->string('nroDocumentoPersona',11)->nullable();
          $table->string('firma',150)->nullable();
          $table->string('dependencia',255)->nullable();
          $table->integer('idDependencia')->nullable();
          $table->integer('idUser')->nullable();
          $table->integer('idDependenciaUser')->nullable();

          /* ==================== PARA DOCUMENTO EXTERNO O TRAMITE VIRTUAL ========================== */
          $table->string('emailOrigen')->nullable();
          $table->string('celularOrigen')->nullable();
          $table->string('direccionOrigen')->nullable();
          $table->string('archivo',255)->nullable(); # url del Archivo
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
        Schema::dropIfExists('documentos');
    }
}
