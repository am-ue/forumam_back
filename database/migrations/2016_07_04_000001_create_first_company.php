<?php

use App\Models\Company;
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
        Company::forceCreate(
            [
                'name'            => 'Forum Arts et Métiers',
                'website'         => url('/'),
                'description'     => '',
                'summary'         => '',
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
                'category_id'     => 1,
                'active'          => true,
                'public'          => false,
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
    }
}
