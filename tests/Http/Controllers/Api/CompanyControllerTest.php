<?php


namespace Tests\Http\Controller\Api;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    public function testAfficherToutesLesEntreprises()
    {
        $showables = factory(Company::class, 3)->create(['active' => 1, 'public' => 1]);
        $others = factory(Company::class, 3)->create(['active' => 0, 'public' => 1]);
        $othersagain = factory(Company::class, 3)->create(['active' => 1, 'public' => 0]);
        $this->json('GET', action('Api\CompanyController@index'));
        $this->seeJson($showables->toArray());
        $this->dontSeeJson($others->toArray());
        $this->dontSeeJson($othersagain->toArray());
    }

    public function testAfficherUneEntreprise()
    {
        $company = factory(Company::class)->create(['active' => 1, 'public' => 1]);
        $this->json('GET', action('Api\CompanyController@show', $company->id));
        $this->seeJson($company->toArray());
    }
}
