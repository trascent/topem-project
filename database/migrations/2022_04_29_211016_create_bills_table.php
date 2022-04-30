<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigInteger('number');
            $table->primary('number');
            $table->string('emisor_name');
            $table->string('emisor_nit')->nullable();
            $table->string('buyer_name');
            $table->string('buyer_nit')->nullable();
            $table->decimal('net_amount', 8, 2, true);
            $table->decimal('iva', 4, 2, true);
            $table->dateTime('bill_purchase_date', 0);
            $table->decimal('total_net_amount', 11, 2, true);
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
        Schema::dropIfExists('bills');
    }
}
