<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'invoices',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuidMorphs('invoiceable');
                $table->timestamp('due_at');

                $table->string('code');

                $table->unsignedBigInteger('paid')->default(0);

                $table->unsignedBigInteger('balance_due')->default(0);

                //            $table->enum('status', ['pending', 'paid', 'partially_paid']);
                $table->timestamps();

                $table->unique(['code', 'invoiceable_type', 'invoiceable_id']);
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
        Schema::dropIfExists('invoices');
    }
}
