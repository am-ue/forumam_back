<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Option;
use App\Models\OptionDetail;
use App\Models\Badge;
use App\Models\User;
use App\ViewsMakers\BadgeViewsMaker;
use Auth;
use Carbon\Carbon;
use Form;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\Datatables\Datatables;

class BadgeController extends Controller
{
    public function edit(BadgeViewsMaker $viewsMaker, $company_id)
    {
        $config = [
            'var'         => 'Ma commande',
            'vars'        => 'commandes',
            'description' => 'Edition',
            'store_url'   => action('Admin\BadgeController@store', ['company_id' => $company_id]),
            'elements'    => $viewsMaker->headerActions,
        ];

        $total = \App\Models\Order::whereCompanyId($company_id)->whereOptionId(2)->sum('value');
        if ($total == 0) {
            alert()->error(
                '<strong> Il n\'y a aucune personne actuellement enregistrée. Merci de finir votre commande.',
                'Désolé...'
            )->html()->autoclose(5000);
            return redirect()->action('Admin\OrderController@edit', $company_id);
        }
        $badgesValues = Badge::whereCompanyId($company_id)->get();

        $badges = [];
        for ($i = 0; $i < $total; $i++) {
            $badges[$i+1] = new Badge([
                'first_name' => isset($badgesValues[$i]) ? $badgesValues[$i]->first_name : null,
                'last_name' =>  isset($badgesValues[$i]) ? $badgesValues[$i]->last_name : null,
            ]);
        }
        return view('badge_form', compact('config', 'company_id', 'badges'));
    }


    public function store(Request $request, Company $company)
    {
        Badge::whereCompanyId($company->id)->delete();

        foreach ($request->except('_token') as $badge) {
            if (empty($badge['first_name']) || empty($badge['last_name'])) {
                continue;
            };

            $company->badges()->create($badge);
        }
        alert()->success('Vos badges ont été modifés avec succés.', 'Merci !')
            ->html()->autoclose(5000);
        return redirect()->action('Admin\OrderController@index', $company->id);
    }
}
