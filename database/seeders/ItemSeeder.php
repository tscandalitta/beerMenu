<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
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
            "price" => 250
        ]);

        DB::table('items')->insert([
            "name" => "Black IPA",
            "in_stock" => true,
            "description" => "Mas amarga y mas refrescante",
            "price" => 300
        ]);

        DB::table('items')->insert([
            "name" => "APA",
            "in_stock" => true,
            "description" => "Ni tan amarga ni tan refrescante",
            "price" => 200
        ]);

        DB::table('items')->insert([
            "name" => "Scottish",
            "in_stock" => true,
            "description" => "Menos amarga y menos refrescante",
            "price" => 220
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
            "price" => 200
        ]);

        DB::table('items')->insert([
            "name" => "Golden",
            "in_stock" => true,
            "description" => "Esta buena!",
            "price" => 200
        ]);
    }
}
