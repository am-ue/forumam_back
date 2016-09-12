<?php

use App\Models\OptionRelation;
use Illuminate\Database\Migrations\Migration;

class PopulateOptionRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        OptionRelation::forceCreate([
            'parent_id' => 1,
            'child_id' => 3,
            'parent_value' => 1,
            'child_value'=> 2
        ]);
        OptionRelation::forceCreate([
            'parent_id' => 2,
            'child_id' => 3,
            'parent_value' => 1,
            'child_value'=> 3
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
