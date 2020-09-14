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
        Derivation::create([
            'title' => 'Nódulo',
            'description' => 'Nódulo',
            'establishment_code_deis' => '102100'
        ]);
        Derivation::create([
            'title' => 'Dolor',
            'description' => 'Dolor',
            'establishment_code_deis' => '102100'
        ]);
        Derivation::create([
            'title' => 'Microcalcificaciones',
            'description' => 'NódMicrocalcificacionesulo',
            'establishment_code_deis' => '102100'
        ]);
        Derivation::create([
            'title' => 'Biopsias',
            'description' => 'Biopsias',
            'establishment_code_deis' => '102100'
        ]);

    }
}
