<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateCategories extends Migration
{
    protected $categories = [
        ['name' => 'Formation - Start Up', 'color' => '#e82285', 'map' => 'plan'],
        ['name' => 'Conseil - Finance - Service', 'color' => '#e82222', 'map' => 'plan'],
        ['name' => 'Agroalimentaire - Industrie - Grande distribution', 'color' => '#e88522', 'map' => 'plan'],
        ['name' => 'Bâtiment - Construction', 'color' => '#2282e8', 'map' => 'plan'],
        ['name' => 'Energie - BTP', 'color' => '#22e888', 'map' => 'plan'],
        ['name' => 'Transport - Défense', 'color' => '#b622e8', 'map' => 'plan'],
    ];

    public function up()
    {
        $categories = [];
        foreach ($this->categories as $category) {
            $category['created_at'] = new DateTime();
            $category['updated_at'] = $category['created_at'];
            $categories[] = $category;
        }

        \App\Models\Category::insert($categories);
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
