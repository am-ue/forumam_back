<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('website');
            $table->text('description');
            $table->text('summary');
            $table->text('figures');
            $table->text('staffing');
            $table->text('profiles');
            $table->text('more');
            $table->string('logo');
            $table->string('stand');
            $table->text('billing_contact');
            $table->text('billing_address');
            $table->string('billing_delay');
            $table->string('billing_method');
            $table->integer('category_id')->unsigned();
            $table->boolean('active')->default(0);
            $table->boolean('public')->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companies');
    }
}
