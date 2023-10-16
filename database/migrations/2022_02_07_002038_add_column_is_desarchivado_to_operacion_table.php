<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsDesarchivadoToOperacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operacions', function (Blueprint $table) {
            $table->boolean('isDesarchivado')->nullable()->after('idArchivado');
            $table->datetime('fechaDesarchivado')->nullable()->after('isDesarchivado');
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
