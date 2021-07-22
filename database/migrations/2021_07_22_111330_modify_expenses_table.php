<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('code');

            $table->foreignUuid('company_id')->references('id')->on('companies')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignUuid('vendor_id')
                ->nullable()
                ->references('id')->on('companies')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->timestamp('expensed_at')->nullable();

            $table->unsignedBigInteger('sub_total')->default(0);

            $table->unsignedBigInteger('total')->default(0);

            $table->unique(['code', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->id('id');

            $table->dropColumn('code');

            $table->dropColumn('company_id');

            $table->dropColumn('vendor_id');

            $table->dropColumn('sub_total');

            $table->dropColumn('total');

            $table->dropColumn('expensed_at');
        });
    }
}
