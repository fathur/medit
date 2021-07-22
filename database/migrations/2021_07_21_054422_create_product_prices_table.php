<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'product_prices',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('product_id')->references('id')->on('products')
                    ->cascadeOnDelete()->cascadeOnUpdate();
                $table->unsignedBigInteger('buy_price')->default(0);
                $table->unsignedBigInteger('sell_price')->default(0);
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
        Schema::dropIfExists('product_prices');
    }
}
