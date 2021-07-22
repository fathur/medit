<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'expense_items',
            function (Blueprint $table) {
                $table->uuid('id')->primary();

                $table->foreignUuid('expense_id')->references('id')->on('expenses')
                    ->cascadeOnDelete()->cascadeOnUpdate();

                $table->unsignedInteger('quantity')->default(0);



                $table->string('product');

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
        Schema::dropIfExists('expense_items');
    }
}
