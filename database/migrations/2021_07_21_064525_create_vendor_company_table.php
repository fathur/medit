<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'vendor_company',
            function (Blueprint $table) {
                $table->foreignUuid('vendor_id')->references('id')->on('companies')
                    ->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignUuid('company_id')->references('id')->on('companies')
                    ->cascadeOnDelete()->cascadeOnUpdate();
                $table->timestamps();
                $table->unique(['vendor_id', 'company_id']);
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
        Schema::dropIfExists('vendor_company');
    }
}
