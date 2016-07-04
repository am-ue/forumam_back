<?php

namespace Tests\Models;

use App\Models\User;
use Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testDonnerUnMDPDejaHashe()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('pass')
        ]);
        $this->assertFalse(Hash::needsRehash($user->password));

    }

    public function testDonnerUnMDPNonHashe()
    {
        $user = factory(User::class)->create([
            'password' => 'pass'
        ]);
        $this->assertFalse(Hash::needsRehash($user->password));

    }

    /**
     * @expectedException \Illuminate\Database\QueryException
     * @expectedExceptionMessage  Integrity constraint violation: 19 NOT NULL constraint failed: users.password
     * @expectedExceptionCode    23000
     */
    public function testDonnerUnMDPVide()
    {
        $user = factory(User::class)->create([
            'password' => ''
        ]);

    }
}