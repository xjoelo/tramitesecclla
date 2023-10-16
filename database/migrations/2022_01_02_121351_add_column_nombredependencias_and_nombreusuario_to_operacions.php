<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNombredependenciasAndNombreusuarioToOperacions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operacions', function (Blueprint $table) {
          $table->string('nombreDependencia',250)->nullable()->after('idDependencia');
          $table->string('nombreUsuario',250)->nullable()->after('iduser');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operacions', function (Blueprint $table) {
            //
        });
    }
}
