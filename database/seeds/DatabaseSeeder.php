<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(RegionTableSeeder::class);
        $this->call(CommuneTableSeeder::class);
        $this->call(EstablishmentTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
    }
}
