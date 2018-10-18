<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quotation_id')->unsigned()->index();
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('quotation_payment_methods');
    }
}
