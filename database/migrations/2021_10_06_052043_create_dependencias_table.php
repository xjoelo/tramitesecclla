<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDependenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependencias', function (Blueprint $table) {
            $table->id();

            $table->string('nombre',255)->nullable();
            $table->string('abreviado',55)->nullable();
            $table->string('siglas',255)->nullable();
            $table->string('representante',200)->nullable();
            $table->string('cargo',150)->nullable();

            $table->text('observaciones')->nullable();
            $table->date('fechaRegistro')->nullable();
            $table->integer('maxEnProceso')->default(30);

            $table->boolean('isActive')->default(1);

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
        Schema::dropIfExists('dependencias');
    }
}
