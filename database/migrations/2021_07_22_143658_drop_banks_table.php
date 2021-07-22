<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'payments',
            function (Blueprint $table) {
                $table->dropColumn('pay_from_bank_id');
            }
        );

        Schema::dropIfExists('banks');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create(
            'banks',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->foreignUuid('company_id')->references('id')->on('companies')
                    ->cascadeOnUpdate()->cascadeOnDelete();
                $table->timestamps();
            }
        );

        Schema::table(
            'payments',
            function (Blueprint $table) {
                $table->foreignUuid('pay_from_bank_id')->references('id')->on('banks')
                    ->cascadeOnDelete()->cascadeOnUpdate();
            }
        );
    }
}
