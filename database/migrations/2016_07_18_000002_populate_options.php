<?php

use App\Models\Option;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Option::forceCreate([
            'name'  => 'Stand',
            'type'  => 'select',
            'order' => 1,
        ]);
        Option::forceCreate([
            'name'  => 'Personnes',
            'type'  => 'int',
            'order' => 2,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
