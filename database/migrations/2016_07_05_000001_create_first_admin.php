<?php

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::forceCreate([
            'first_name' => 'Admin',
            'last_name'  => 'ForumAM',
            'phone'      => '0',
            'email'      => 'admin@forum-am.fr',
            'password'   => bcrypt('pass'),
            'company_id' => 1,
            'role'       => 'Admin',
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
