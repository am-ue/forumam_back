<?php

namespace Tests\Controllers;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testRedirectionVersLogin()
    {
        $this->get(route('admin.home'));
        $this->assertRedirectedToRoute('admin.login');
    }
    public function testAccesUneFoisConnecte()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->get(route('admin.home'));
        $this->assertResponseOk();
    }
}
