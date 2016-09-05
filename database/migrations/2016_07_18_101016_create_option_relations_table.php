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
            $table->integer('parent_id');
            $table->string('parent_value');
            $table->integer('child_id');
            $table->string('child_value');
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
        Schema::drop('option_relations');
    }
}
