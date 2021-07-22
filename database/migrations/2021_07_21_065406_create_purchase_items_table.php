<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'purchase_items',
            function (Blueprint $table) {
                $table->uuid('id')->primary();

                $table->foreignUuid('purchase_id')->references('id')->on('purchases')
                    ->cascadeOnDelete()->cascadeOnUpdate();

                $table->foreignUuid('product_price_id')
                    ->nullable()
                    ->references('id')->on('product_prices')
                    ->cascadeOnDelete()->cascadeOnUpdate();


                $table->unsignedInteger('quantity')->default(0);

                $table->foreignUuid('product_id')
                    ->nullable()
                    ->references('id')->on('products')
                    ->cascadeOnDelete()->cascadeOnUpdate();

                $table->unsignedBigInteger('price')->default(0);

                $table->unsignedBigInteger('sub_total')->default(0);

                $table->unsignedBigInteger('total')->default(0);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
}
