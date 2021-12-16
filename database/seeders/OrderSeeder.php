<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Item;
use App\Models\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($id = 1; $id <= 800; $id++){
            $table = Table::all()->random();
            $first_time = strtotime("2020-02-14 10:21:02");
            $second_time = strtotime("2021-12-14 08:21:02");
            $rand_time = rand($first_time, $second_time);
            $rand_date = date('Y-m-d g:i:s', $rand_time);

            echo $rand_date;
            DB::table('orders')->insert([
                'id' => $id,
                'table_id' => $table->id,
                'state' => 'CLOSED',
                'token' => $table->token,
                'created_at' => $rand_date,
            ]);
            for ($j = 1; $j < mt_rand(1,5); $j++) {
                $item = Item::all()->random();
                DB::table('item_order')->insert([
                    'item_id' => $item->id,
                    'order_id' => $id,
                    'items_amount' => mt_rand(1,3),
                ]);
            }
        }
    }
}
