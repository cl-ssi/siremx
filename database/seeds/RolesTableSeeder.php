<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Administrador',
            'slug' => 'administrador'
        ]);

        Role::create([
            'name' => 'Referente Servicio Salud',
            'slug' => 'referenteServicioSocial'
        ]);

        Role::create([
            'name' => 'Referente Comunal',
            'slug' => 'referenteComunal'
        ]);

        Role::create([
            'name' => 'Referente Establecimiento',
            'slug' => 'referenteEstablecimiento'
        ]);
    }
}
