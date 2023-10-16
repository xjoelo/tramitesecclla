<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFormaDocumentoToDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->boolean('formaDocumento')->nullable()->after('origenDocumento'); /* 1= ORIGINAL, 2= COPIA, 3=DIGITAL*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documentos', function (Blueprint $table) {
            //
        });
    }
}
