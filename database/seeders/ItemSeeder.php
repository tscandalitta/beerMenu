<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class
ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            "name" => "IPA",
            "in_stock" => true,
            "description" => "Amarga y refrescante",
            "price" => 280
        ]);

        DB::table('items')->insert([
            "name" => "Black IPA",
            "in_stock" => true,
            "description" => "Mas amarga y mas refrescante",
            "price" => 300
        ]);

        DB::table('items')->insert([
            "name" => "Doble IPA",
            "in_stock" => true,
            "description" => "Bien fuerte",
            "price" => 290
        ]);

        DB::table('items')->insert([
            "name" => "APA",
            "in_stock" => true,
            "description" => "Ni tan amarga ni tan refrescante",
            "price" => 250
        ]);

        DB::table('items')->insert([
            "name" => "Scottish",
            "in_stock" => true,
            "description" => "Menos amarga y menos refrescante",
            "price" => 255
        ]);

        DB::table('items')->insert([
            "name" => "Scotch",
            "in_stock" => true,
            "description" => "Un poco mas amarga que la Scottish",
            "price" => 220
        ]);

        DB::table('items')->insert([
            "name" => "Honey",
            "in_stock" => true,
            "description" => "Bastante suave, pero refrescante",
            "price" => 215
        ]);

        DB::table('items')->insert([
            "name" => "Golden",
            "in_stock" => true,
            "description" => "Esta buena!",
            "price" => 200
        ]);

        DB::table('items')->insert([
            "name" => "Frutos rojos",
            "in_stock" => true,
            "description" => "Bien dulzona",
            "price" => 235
        ]);

        DB::table('items')->insert([
            "name" => "Porter",
            "in_stock" => true,
            "description" => "Negra corpulenta",
            "price" => 240
        ]);

        DB::table('items')->insert([
            "name" => "Jack Black",
            "in_stock" => true,
            "description" => "Inventada por Chuck Norris porque la doble ipa le parecía suave",
            "price" => 335
        ]);

        DB::table('items')->insert([
            "name" => "Quilmes",
            "in_stock" => true,
            "description" => "El sabor del encuentro",
            "price" => 180
        ]);

        DB::table('items')->insert([
            "name" => "Palermo",
            "in_stock" => true,
            "description" => "El sueño de albañil a las 3 de la tarde",
            "price" => 120
        ]);
    }
}
