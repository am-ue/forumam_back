<?php

use App\Models\OptionDetail;
use Illuminate\Database\Migrations\Migration;

class PopulateOptionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        OptionDetail::forceCreate([
            'option_id'  => 1,
            'label'  => '134m²',
            'price' => 13.4,
        ]);
        OptionDetail::forceCreate([
            'option_id'  => 1,
            'label'  => '212m²',
            'price' => 21.2,
        ]);
        OptionDetail::forceCreate([
            'option_id'  => 2,
            'label'  => '',
            'price' => 134,
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
