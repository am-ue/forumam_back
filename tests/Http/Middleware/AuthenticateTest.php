<?php

namespace Tests\Http\Middleware;

use App\Models\User;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        \Route::get('/essai', ['middleware' => 'auth', function () {
            return 'ok';
        }]);
    }
    public function testRedirectionVersLogin()
    {
        $this->get('/essai');
        $this->assertResponseStatus(302);
        $this->assertRedirectedToRoute('admin.login');
    }

    public function testJsonUnauthorize()
    {
        $this->json('GET', '/essai');
        $this->assertResponseStatus(401);
        $this->see('Unauthorized');
    }

    public function testAccesUneFoisConnecte()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->get('/essai');
        $this->assertResponseOk();
        $this->assertEquals('ok', $this->response->content());
    }
}
