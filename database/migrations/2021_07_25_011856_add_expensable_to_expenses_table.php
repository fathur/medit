<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpensableToExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->nullableUuidMorphs('expensable');

            $table->foreignUuid('from_account_id')
                ->nullable()
                ->comment('Which account that expenses come from.')
                ->references('id')->on('accounts')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignUuid('to_account_id')
                ->nullable()
                ->comment('Which account that expenses transfer to.')
                ->references('id')->on('accounts')
                ->cascadeOnUpdate()->cascadeOnDelete();
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
            $table->dropMorphs('expensable');
            $table->dropColumn('from_account_id');
            $table->dropColumn('to_account_id');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignUuid('account_id')
                ->nullable()
                ->comment('Which account that expenses come from.')
                ->references('id')->on('accounts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }
}
