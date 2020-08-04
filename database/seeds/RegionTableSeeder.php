<?php

use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            [ 'id' => 1 , 'name' => 'Región De Tarapacá'],
            [ 'id' => 2 , 'name' => 'Región De Antofagasta'],
            [ 'id' => 3 , 'name' => 'Región De Atacama'],
            [ 'id' => 4 , 'name' => 'Región De Coquimbo'],
            [ 'id' => 5 , 'name' => 'Región De Valparaíso'],
            [ 'id' => 6 , 'name' => 'Región Metropolitana de Santiago'],
            [ 'id' => 7 , 'name' => 'Región Del Libertador Gral. B. OHiggins'],
            [ 'id' => 8 , 'name' => 'Región Del Maule'],
            [ 'id' => 9 , 'name' => 'Región De Ñuble'],
            [ 'id' => 10 , 'name' => 'Región Del Bíobío'],
            [ 'id' => 11, 'name' => 'Región De La Araucanía'],
            [ 'id' => 12, 'name' => 'Región De Los Ríos'],
            [ 'id' => 13, 'name' => 'Región De Los Lagos'],
            [ 'id' => 14, 'name' => 'Región De Aysén del General Carlos Ibañez del Campo'],
            [ 'id' => 15, 'name' => 'Región De Magallanes y de la Antártica Chilena'],
            [ 'id' => 16, 'name' => 'Región De Arica Parinacota']
        ]);
        
    }
}
