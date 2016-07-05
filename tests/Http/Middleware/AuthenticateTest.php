<?php

namespace Tests\Http\Middleware;

use App\Models\User;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    public function testRedirectionVersLogin()
    {
        $this->get(route('admin.home'));
        $this->assertResponseStatus(302);
        $this->assertRedirectedToRoute('admin.login');
    }

    public function testJsonUnauthorize()
    {
        $this->json('GET', route('admin.home'));
        $this->assertResponseStatus(401);
        $this->see('Unauthorized');
    }

    public function testAccesUneFoisConnecte()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->get(route('admin.home'));
        $this->assertResponseOk();
    }
}
