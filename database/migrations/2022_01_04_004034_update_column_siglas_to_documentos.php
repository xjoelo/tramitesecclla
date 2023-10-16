<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnSiglasToDocumentos extends Migration
{
  public function up()
  {
    Schema::table('documentos', function (Blueprint $table) {
      $table->text('siglas')->nullable()->change();
    });
  }

  public function down()
  {
    Schema::table('documentos', function (Blueprint $table) {
      //
    });
  }
}
