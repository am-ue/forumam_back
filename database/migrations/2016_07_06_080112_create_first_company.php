<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        factory(\App\Models\Company::class)->create(
            [
                'name'            => 'Forum Arts et Métiers',
                'website'         => url('/'),
                'description'     => '',
                'figures'         => '',
                'staffing'        => '',
                'profiles'        => '',
                'more'            => '',
                'logo'            => 'img/ue/square_logo_white.png',
                'stand'           => '',
                'billing_contact' => '',
                'billing_address' => '',
                'billing_delay'   => '',
                'billing_method'  => '',
                'category_id'     => 0,
                'active'          => 1,
                'public'          => 0,
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
