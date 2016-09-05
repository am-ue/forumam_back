<?php

namespace Tests\Http\Middleware;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CanAccessTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testAccessAdminNonAutorise()
    {
        \Route::get('/essai', ['middleware' => 'canAccess', function () {
            return 'ok';
        }]);
        $user = factory(User::class)->create();
        $this->be($user);
        $this->get('/essai');
        $this->assertCantAccess();
    }

    public function testAccesAdminAutorise()
    {
        \Route::get('/essai', ['middleware' => 'canAccess', function () {
            return 'ok';
        }]);
        $user = factory(User::class)->create(['company_id' => 1]);
        $this->be($user);
        $this->get('/essai');
        $this->assertCanAccess();
    }

    public function testAccesAUnUserNonAutorise()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        \Route::get('/essai/{users}', ['middleware' => 'canAccess', function () {
            return 'ok';
        }]);
        $this->get('/essai/' . ($user->id + 1));
        $this->assertCantAccess();
    }

    public function testAccesAUnUserAutorise()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        \Route::get('/essai/{user}', ['middleware' => 'canAccess', function (User $user) {
            return 'ok';
        }]);
        $this->get('/essai/' . ($user->id));
        $this->assertCanAccess();
    }

    public function testAccesAUneEntrepriseNonAutorisee()
    {
        \Route::get('/essai/{company}', ['middleware' => 'canAccess', function () {
            return 'ok';
        }]);
        $user = factory(User::class)->create();
        $this->be($user);
        $this->get('/essai/' . ($user->company_id + 1));
        $this->assertCantAccess();
    }

    public function testAccesAUneEntrepriseAutorisee()
    {
        \Route::get('/essai/{company}', ['middleware' => 'canAccess', function () {
            return 'ok';
        }]);
        $user = factory(User::class)->create(['company_id' => 134]);
        $this->be($user);
        $this->get('/essai/' . ($user->company_id));
        $this->assertCanAccess();
    }

    protected function assertCantAccess()
    {
        $this->assertResponseStatus(302);
        $this->assertRedirectedToRoute('admin.home');
        $this->assertSessionHas('sweet_alert.type', 'error');
        $this->assertSessionHas('sweet_alert.text', 'Vous n\'êtes pas autorisé à consulter cette page.');
    }

    protected function assertCanAccess()
    {
        $this->assertResponseOk();
        $this->assertSessionMissing('sweet_alert');
        $this->see('ok');
    }
}
