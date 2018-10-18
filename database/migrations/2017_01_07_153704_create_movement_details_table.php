<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('movement_id')->unsigned()->index();
            $table->foreign('movement_id')->references('id')->on('movements')->onDelete('cascade');
            $table->integer('document_id')->unsigned()->index();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            /*$table->integer('provider_id')->unsigned()->index();
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');*/
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('cost_id')->unsigned()->index();
            $table->foreign('cost_id')->references('id')->on('costs')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2);
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
        Schema::drop('movement_details');
    }
}
