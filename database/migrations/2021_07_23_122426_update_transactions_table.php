<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('code');
            $table->timestamp('transaction_at')->nullable();
            $table->dropColumn('user_id');
            $table->dropColumn('nominal');

            $table->foreignUuid('account_id')
                ->references('id')->on('accounts')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignUuid('customer_id')
                ->references('id')->on('customers')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignUuid('company_id')
                ->references('id')->on('companies')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('sub_total')->default(0);
            $table->unsignedBigInteger('total')->default(0);

            $table->string('remarks')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('transaction_at');
            $table->bigInteger('nominal');

            $table->foreignUuid('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->dropColumn('account_id');

            $table->dropColumn('customer_id');
            $table->dropColumn('company_id');

            $table->dropColumn('sub_total');
            $table->dropColumn('total');
        });
    }
}
