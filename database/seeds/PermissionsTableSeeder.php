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
            'name' => 'Dashboard',
            'slug' => 'dashboard.index'
        ]);
        Permission::create([
            'name' => 'Navegar Usuario',
            'slug' => 'user.index'
        ]);
        Permission::create([
            'name' => 'Crear Usuario',
            'slug' => 'user.create'
        ]);
        Permission::create([
            'name' => 'Editar Usuario',
            'slug' => 'user.edit'
        ]);
        Permission::create([
            'name' => 'Ver Usuario',
            'slug' => 'user.show'
        ]);
        Permission::create([
            'name' => 'Activar Usuario',
            'slug' => 'user.activate'
        ]);
        Permission::create([
            'name' => 'Navegar Roles',
            'slug' => 'rol.index'
        ]);
        Permission::create([
            'name' => 'Permisos asociados al usuario',
            'slug' => 'user.permission'
        ]);

        Permission::create([
            'name' => 'Navegar Roles',
            'slug' => 'role.index'
        ]);
        Permission::create([
            'name' => 'Crear Roles',
            'slug' => 'role.create'
        ]);
        Permission::create([
            'name' => 'Editar Roles',
            'slug' => 'role.edit'
        ]);

        Permission::create([
            'name' => 'Navegar Permiso',
            'slug' => 'permission.index'
        ]);
        Permission::create([
            'name' => 'Crear Permiso',
            'slug' => 'permission.create'
        ]);
        Permission::create([
            'name' => 'Editar Permiso',
            'slug' => 'permission.edit'
        ]);

        Permission::create([
            'name' => 'Navegar Paciente',
            'slug' => 'patient.index'
        ]);
        Permission::create([
            'name' => 'Crear Paciente',
            'slug' => 'patient.create'
        ]);
        Permission::create([
            'name' => 'Editar Paciente',
            'slug' => 'patient.edit'
        ]);

        Permission::create([
            'name' => 'Navegar Exámen',
            'slug' => 'exam.index'
        ]);
        Permission::create([
            'name' => 'Crear Exámen',
            'slug' => 'exam.create'
        ]);
        Permission::create([
            'name' => 'Editar Exámen',
            'slug' => 'exam.edit'
        ]);
        Permission::create([
            'name' => 'Cargar Exámenes Masivamente',
            'slug' => 'exam.load'
        ]);
        Permission::create([
            'name' => 'Listado de Cargas Exámenes Masivamente',
            'slug' => 'examLoadHistory.load'
        ]);
        // REPORTES
        Permission::create([
            'name' => 'Reporte listado MX por BIRARDS',
            'slug' => 'reportMXBirards.index'
        ]);
        Permission::create([
            'name' => 'Reporte listado MX',
            'slug' => 'reportMX.index'
        ]);
        Permission::create([
            'name' => 'Reporte de BIRARDS por edad',
            'slug' => 'reportBirardsAge.index'
        ]);
        Permission::create([
            'name' => 'Reporte Historial de paciente',
            'slug' => 'patientHistory.index'
        ]);
        Permission::create([
            'name' => 'Reporte Cartola de paciente clinico',
            'slug' => 'patientHistoryClinical.index'
        ]);
        // FILTROS patientHistory.index
        Permission::create([
            'name' => 'Filtro: Establecimientoa Toma de Exámen',
            'slug' => 'establishmentExam.filter'
        ]);
        Permission::create([
            'name' => 'Filtro: Ver Establecimientos',
            'slug' => 'establishment.filter'
        ]);
        Permission::create([
            'name' => 'Filtro: Ver Comunas',
            'slug' => 'commune.filter'
        ]);
        
    }
}
