<?php

use Illuminate\Database\Seeder;
use App\Derivation;

class DerivationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Derivation::create([
            'title' => 'Screening',
            'description' => 'Screening'
        ]);
        Derivation::create([
            'title' => 'EFM +',
            'description' => 'EFM +'
        ]);
        Derivation::create([
            'title' => 'Antecedentes Linea Materna ',
            'description' => 'Antecedentes Linea Materna '
        ]);
        Derivation::create([
            'title' => 'Control Anual',
            'description' => 'Control Anual'
        ]);
    }
}
