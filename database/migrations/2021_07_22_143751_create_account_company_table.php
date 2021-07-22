<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'account_company',
            function (Blueprint $table) {
                $table->foreignUuid('account_id')
                    ->references('id')
                    ->on('accounts')
                    ->cascadeOnUpdate()->cascadeOnDelete();

                $table->foreignUuid('company_id')
                    ->references('id')
                    ->on('companies')
                    ->cascadeOnUpdate()->cascadeOnDelete();

                $table->string('value');

                $table->timestamps();

                $table->unique(['account_id', 'company_id']);
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
        Schema::dropIfExists('account_company');
    }
}
