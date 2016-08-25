<?php


namespace Tests\Http\Controller\Api;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    public function testAfficherToutesLesEntreprises()
    {
        factory(Company::class, 3)->create(['active' => 1, 'public' => 1]);
        factory(Company::class, 3)->create(['active' => 0, 'public' => 1]);
        factory(Company::class, 3)->create(['active' => 1, 'public' => 0]);
        $this->json('GET', action('Api\CompanyController@index'));
        $this->receiveJson();
        $this->count(3, $this->decodeResponseJson());

    }

    public function testAfficherUneEntreprise()
    {
        factory(Company::class, 3)->create(['active' => 1, 'public' => 1]);
        factory(Company::class, 3)->create(['active' => 0, 'public' => 1]);
        factory(Company::class, 3)->create(['active' => 1, 'public' => 0]);
        $this->json('GET', action('Api\CompanyController@index'));
        $this->receiveJson();
        $this->count(3, $this->decodeResponseJson());

    }
}
