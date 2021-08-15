<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('item_order')) {
            Schema::create('item_order', function(Blueprint $table) {
                $table->integer('item_id')->unsigned()->index();
                $table->integer('order_id')->unsigned()->index();
                $table->foreign('item_id')->references('id')->on('items');
                $table->foreign('order_id')->references('id')->on('orders');
                $table->integer('items_amount');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_order');
    }
}
