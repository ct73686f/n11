<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MovementsCash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements_cash', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_cash_id')->unsigned()->index();
            $table->foreign('document_cash_id')->references('id')->on('documents_cash')->onDelete('cascade');
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
        Schema::drop('movements_cash');
    }
}
