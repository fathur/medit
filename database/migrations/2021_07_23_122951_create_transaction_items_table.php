<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('transaction_id')
                ->references('id')->on('transactions')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedInteger('quantity')->default(0);

            $table->foreignUuid('product_id')
                ->references('id')->on('products')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('price')->default(0);

            $table->unsignedBigInteger('sub_total')->default(0);

            $table->unsignedBigInteger('total')->default(0);
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
        Schema::dropIfExists('transaction_items');
    }
}
