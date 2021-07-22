<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'payments',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('invoice_id')
                    ->references('id')
                    ->on('invoices')
                    ->cascadeOnDelete()->cascadeOnUpdate();
                $table->unsignedBigInteger('nominal')->default(0);

                $table->timestamp('paid_at');

                $table->foreignUuid('pay_from_bank_id')->references('id')->on('banks')
                    ->cascadeOnDelete()->cascadeOnUpdate();

                $table->unsignedBigInteger('total')->default(0)
                    ->comment('Nominal minus withholdings');

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
        Schema::dropIfExists('payments');
    }
}
