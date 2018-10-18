<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('client_id')->unsigned()->index();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            /*$table->integer('payment_method_id')->unsigned()->index();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->integer('credit_type_id')->unsigned()->index();
            $table->foreign('credit_type_id')->references('id')->on('credit_types')->onDelete('cascade');*/
            $table->string('nit', 20);
            $table->string('description');
            $table->decimal('total', 10, 2);
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
        Schema::drop('invoices');
    }
}
