<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Item;
use App\Models\Table;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use DateInterval;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indexDay = new DateTime("2020-09-14 00:00:00");
        $today = (new DateTime("now"));
        $lastId = 1;
        while($today->format("Y-m-d 00:00:00") != $indexDay->format("Y-m-d 00:00:00")){
            $table = Table::all()->random();
            $date = new DateTime($indexDay->format("Y-m-d H:i:s"));
            $randomId = mt_rand(1,14);
            for ($id = $lastId; $id <= $lastId + $randomId; $id++) {
                $date->add(new DateInterval('PT1H'));
                DB::table('orders')->insert([
                    'id' => $id,
                    'table_id' => $table->id,
                    'state' => 'CLOSED',
                    'token' => $table->token,
                    'created_at' => $date->format("Y-m-d H:i:s"),
                ]);
                for ($j = 1; $j < mt_rand(1, 5); $j++) {
                    $item = Item::all()->random();
                    DB::table('item_order')->insert([
                        'item_id' => $item->id,
                        'order_id' => $id,
                        'items_amount' => mt_rand(1, 3),
                    ]);
                }
            }
            $lastId += $randomId + 1;
            $indexDay->add(new DateInterval('P1D'));
        }
    }
}
