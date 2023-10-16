<?php

namespace Database\Seeders;

use App\Models\NumeracionNumeroDocumento;
use Illuminate\Database\Seeder;

class NumeracionNumeroDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $numeracion1 = new NumeracionNumeroDocumento;
      $numeracion1->tipo = 'DOC';
      $numeracion1->origen = 1;
      $numeracion1->numero = 1;
      $numeracion1->save();

      $numeracion2 = new NumeracionNumeroDocumento;
      $numeracion2->tipo = 'DOC';
      $numeracion2->origen = 0;
      $numeracion2->numero = 1;
      $numeracion2->save();
    }
}
