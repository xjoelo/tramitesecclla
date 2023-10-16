<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivadors', function (Blueprint $table) {
            $table->id();

            $table->integer('idDependencia')->nullable();
            $table->string('nombre',255)->nullable();
            $table->string('periodo',4)->nullable();
            $table->integer('isPersonal')->nullable();
            $table->integer('idUser')->nullable();

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
        Schema::dropIfExists('archivadors');
    }
}
