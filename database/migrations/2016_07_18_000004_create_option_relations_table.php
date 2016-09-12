<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('parent_value');
            $table->integer('child_id')->unsigned();
            $table->string('child_value');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('option_details')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('child_id')->references('id')->on('option_details')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('option_relations');
    }
}
