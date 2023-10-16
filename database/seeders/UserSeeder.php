<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dependencia;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$area = new Dependencia;
		$area->nombre = "TRÁMITE VIRTUAL";
		$area->abreviado = "TR-VIR";
		$area->siglas = "TR-VIR";
		$area->representante = "ASISTENTE VIRTUAL";
		$area->cargo = "ASISTENTE VIRTUAL";
		$area->save();

		$areaAdmin = new Dependencia;
		$areaAdmin->nombre = "OFICINA GENERAL DE INFORMÁTICA Y COMPUTACIÓN";
		$areaAdmin->abreviado = "INFORMÁTICA";
		$areaAdmin->siglas = "OGIC";
		$areaAdmin->representante = "RUTTI GUEVARA ALEXANDER";
		$areaAdmin->cargo = "JEFE DE AREA";
		$areaAdmin->save();

		$user = new User;
		$user->nombres = "ASISTENTE TRÁMITE VIRTUAL";
		$user->iniciales = "ASI-VIR";
		$user->idDependencia = $area->id;
		$user->username = "avirtual";
		$user->password = '123456';
		$user->idRol = 1;
		$user->save();

		$userAdmin = new User;
		$userAdmin->nombres = "ADMINISTADOR DE SISTEMAS";
		$userAdmin->iniciales = "ADMIN";
		$userAdmin->idDependencia = $areaAdmin->id;
		$userAdmin->username = "admin";
		$userAdmin->password = 'admin123++';
		$userAdmin->idRol = 1;
		$userAdmin->email = 'joelchavez.py@gmail.com';
		$userAdmin->save();


		
    }
}
