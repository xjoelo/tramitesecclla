<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdArchivadorToOperacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operacions', function (Blueprint $table) {
            $table->integer('idArchivado')->nullable()->after('idDocumentoAdjunto');
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
