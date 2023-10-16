<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('dni',8)->nullable();
            $table->string('nombres',50)->nullable();
            $table->string('apellidoPaterno',50)->nullable();
            $table->string('apellidoMaterno',50)->nullable();
            $table->string('iniciales',8)->nullable();
            $table->date('fechaNacimiento')->nullable();

            $table->string('celular',10)->nullable();
            $table->string('direccion',255)->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->integer('idDependencia')->nullable();
            $table->string('cargo',150)->nullable();
            $table->text('observaciones')->nullable();

            $table->string('username');
            $table->string('password');

            $table->boolean('isPublico')->nullable();#Atiende al Publico 1=> SI ,0 => NO;
            $table->integer('idRol')->nullable();

            $table->boolean('isActive')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
