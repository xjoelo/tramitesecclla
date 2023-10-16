<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoDocumentoColumnToNumeracionTipoDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('numeracion_tipo_documentos', function (Blueprint $table) {
            $table->boolean('isPersonal')->nullable()->after('idUsuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('numeracion_tipo_documentos', function (Blueprint $table) {

        });
    }
}
