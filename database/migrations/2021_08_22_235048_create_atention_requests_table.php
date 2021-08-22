<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtentionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atention_requests', function (Blueprint $table) {
            $table->id();
            $table->foreign('table_id')->references('id')->on('tables');
            $table->enum('type', ['BILL', 'WAITER']);
            $table->char('comments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atention_requests');
    }
}
