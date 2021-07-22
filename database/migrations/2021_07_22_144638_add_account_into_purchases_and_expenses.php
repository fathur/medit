<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountIntoPurchasesAndExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'purchases',
            function (Blueprint $table) {
                $table->foreignUuid('account_id')
                    ->nullable()
                    ->comment('Which account that purchases come from.')
                    ->references('id')->on('accounts')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            }
        );

        Schema::table(
            'expenses',
            function (Blueprint $table) {
                $table->foreignUuid('account_id')
                    ->nullable()
                    ->comment('Which account that expenses come from.')
                    ->references('id')->on('accounts')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
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
        Schema::table(
            'purchases',
            function (Blueprint $table) {
                $table->dropColumn('account_id');
            }
        );

        Schema::table(
            'expenses',
            function (Blueprint $table) {
                $table->dropColumn('account_id');
            }
        );
    }
}
