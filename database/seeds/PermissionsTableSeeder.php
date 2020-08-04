<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Navegar Usuario',
            'slug' => 'usuario.index'
        ]);
        Permission::create([
            'name' => 'Crear Usuario',
            'slug' => 'usuario.crear'
        ]);
        Permission::create([
            'name' => 'Editar Usuario',
            'slug' => 'usuario.editar'
        ]);
        Permission::create([
            'name' => 'Ver Usuario',
            'slug' => 'usuario.ver'
        ]);
        Permission::create([
            'name' => 'Activar Usuario',
            'slug' => 'usuario.activar'
        ]);
        Permission::create([
            'name' => 'Desactivar Usuario',
            'slug' => 'usuario.desactivar'
        ]);
        Permission::create([
            'name' => 'Navegar Roles',
            'slug' => 'rol.index'
        ]);
        
    }
}
