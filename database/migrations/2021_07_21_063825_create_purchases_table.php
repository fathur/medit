<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'purchases',
            function (Blueprint $table) {
                $table->uuid('id')->primary();

                $table->string('code');

                $table->foreignUuid('company_id')->references('id')->on('companies')
                    ->cascadeOnDelete()->cascadeOnUpdate();

                $table->foreignUuid('vendor_id')->references('id')->on('companies')
                    ->cascadeOnDelete()->cascadeOnUpdate();

                $table->unsignedBigInteger('sub_total')->default(0);

                $table->unsignedBigInteger('total')->default(0);

                $table->timestamps();

                $table->unique(['code', 'company_id']);
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
        Schema::dropIfExists('purchases');
    }
}
