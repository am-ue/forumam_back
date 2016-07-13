<?php

namespace Tests\Http\Middleware;

use App\Models\Company;
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

    public function testAccesUneFoisConnecteEtCompanyAuthorisee()
    {
        $user = factory(User::class)->create(['company_id' => 1]);
        $this->be($user);
        $this->get('/essai');
        $this->assertResponseOk();
        $this->assertEquals('ok', $this->response->content());
    }

    public function testAccesUneFoisConnecteEtCompanyNonAuthorisee()
    {
        $company = factory(Company::class)->create(['active' => 0]);
        $user = factory(User::class)->create(['company_id' => $company->id]);
        $this->be($user);
        $this->get('/essai');
        $this->assertRedirectedToRoute('admin.login');
        $this->assertSessionHas('sweet_alert.alert');
        $this->assertSessionHas('sweet_alert.type', 'error');
        $this->assertSessionHas(
            'sweet_alert.text',
            'Vous n\'êtes pas autorisé à vous connecter.<br/> Merci de contacter un responsable du forum.'
        );
    }
}
