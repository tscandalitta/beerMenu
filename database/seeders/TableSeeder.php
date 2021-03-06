<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++){
            DB::table('tables')->insert([
                'number' => $i,
                'token' => Str::random(20),
            ]);
        }

        DB::table('tables')->insert([
            'number' => 11,
            'token' => "AAA",
        ]);

    }
}
