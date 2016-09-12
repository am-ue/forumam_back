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
            'password' => bcrypt('pass'),
        ]);
        $this->assertFalse(Hash::needsRehash($user->password));

    }

    public function testDonnerUnMDPNonHashe()
    {
        $user = factory(User::class)->create([
            'password' => 'pass',
        ]);
        $this->assertFalse(Hash::needsRehash($user->password));

    }

    /**
     * @expectedException \Illuminate\Database\QueryException
     * @expectedExceptionMessage  Integrity constraint violation
     * @expectedExceptionCode     23000
     */
    public function testDonnerUnMDPVide()
    {
        $user = factory(User::class)->create([
            'password' => '',
        ]);

    }

    public function testDemanderNomComplet()
    {
        $user = factory(User::class)->create([
            'first_name' => 'foo',
            'last_name'  => 'bar',
        ]);

        $this->assertEquals('Foo BAR', $user->full_name);

    }

    public function testisAdmin()
    {
        $user = factory(User::class)->create(['company_id' => 1]);
        $this->assertTrue($user->isAdmin());

        $user->company_id = 2;
        $this->assertFalse($user->isAdmin());
    }
}
