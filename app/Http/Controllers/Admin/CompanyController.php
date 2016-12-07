<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use App\ViewsMakers\CompanyViewsMaker;
use Auth;
use Carbon\Carbon;
use Form;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class CompanyController extends Controller
{

    public function index(CompanyViewsMaker $viewsMaker)
    {
        $config = [
            'var'         => 'entreprise',
            'vars'        => 'entreprises',
            'description' => 'liste',
            'ajax_url'    => action('Admin\CompanyController@datatable'),
            'elements'    => $viewsMaker->index()->headerActions,
        ];
        $columns = [
            'Nom'       => 'name',
            'Stand'     => 'stand',
            'Categorie' => 'category.name',
            'Contact'   => 'contact.full_name',
            'Etat'      => 'state',
            'MàJ'       => 'updated_at',

        ];
        return view('admin.index', compact('config', 'columns'));
    }


    public function create(CompanyViewsMaker $viewsMaker)
    {
        $config = [
            'title'     => 'Ajouter une entreprise',
            'store_url' => action('Admin\CompanyController@store'),
        ];

        $fields = $viewsMaker->create()->fields;

        return view('admin.create', compact('config', 'fields'));
    }


    public function store(CompanyStoreRequest $request)
    {
        $company = new Company($request->all());

        if ($request->has('stand')) {
            $company->stand = $request->input('stand');
        }

        $company->active = true;
        $company->public = false;
        $company->category_id = $request->input('category_id');

        $company->save();

        alert()->success('<strong>' . $company->name . '</strong> a été créée avec succés.', 'C\'est tout bon !')
            ->html()->autoclose(7000);
        return;
    }


    public function show(Company $company, CompanyViewsMaker $viewsMaker)
    {

        $viewsMaker = $viewsMaker->show($company);

        $config = [
            'var'         => 'entreprise',
            'vars'        => 'entreprises',
            'description' => $company->name,
            'elements'    => $viewsMaker->headerActions,
        ];

        $fields = $viewsMaker->fields;
        $object = $company;
        return view('admin.show', compact('config', 'fields', 'object'));
    }


    public function edit(Company $company, CompanyViewsMaker $viewsMaker)
    {
        $viewsMaker = $viewsMaker->edit($company);

        $config = [
            'var'         => 'entreprise',
            'vars'        => 'entreprises',
            'description' => $company->name,
            'update_url'  => action('Admin\CompanyController@update', $company->id),
            'cancel_url'  => action('Admin\CompanyController@index'),
            'elements'    => $viewsMaker->headerActions,
        ];

        $fields = $viewsMaker->fields;
        $object = $company;
        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(Requests\CompanyUpdateRequest $request, Company $company)
    {
        $company->fill($request->all());

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $logo = $request->file('logo');
            $destinationPath = Company::UPLOAD_PATH;
            $extension = $logo->getClientOriginalExtension();
            $fileName = str_random() . '.' . $extension;
            if ($request->file('logo')->move($destinationPath, $fileName)) {
                if (!empty($company->logo)) {
                    \File::delete(public_path($company->logo));
                }
                $company->logo = $destinationPath . $fileName;
            };
        }

        if (Auth::user()->isAdmin()) {
            if ($request->has('stand')) {
                $company->stand = $request->input('stand');
            }
            if ($request->has('active')) {
                $company->active = $request->input('active');
            }
            if ($request->has('public')) {
                $company->public = $request->input('public');
            }
        }

        $company->save();
        if (Auth::user()->isAdmin()) {
            alert()->success('<strong>' . $company->name . '</strong> a été modifiée avec succés.', 'C\'est tout bon !')
                ->html()->autoclose(7000);
        } else {
            alert()->success('La fiche de votre entreprise a été modifiée. Un administrateur la validera.', 'Merci.')
                ->autoclose(7000);
        }
        return redirect()->back();
    }

    public function destroy(Company $company)
    {
        \File::delete(public_path($company->logo));
        $company->delete();
        return;
    }

    public function datatable(CompanyViewsMaker $viewsMaker)
    {
        $companies = Company::with('category')->get();
        $out = Datatables::of($companies)
            ->editColumn('category.name', function (Company $company) {
                $category = $company->category;
                return (string)link_to_action('Admin\CategoryController@show', $category->name, $category->id);
            })
            ->editColumn('contact.full_name', function (Company $company) {
                $contact = $company->contact;
                return !$contact ? 'Aucun contact' : (string)link_to_action('Admin\UserController@show', $contact->full_name, $contact->id);
            })
            ->editColumn('state', function (Company $company) use ($viewsMaker) {
                $active = $viewsMaker->badgeHelper($company->active, 'Act.', 'Inact.');
                $public = $viewsMaker->badgeHelper($company->public, 'Pub.', 'Masq.');
                return $active . ' ' . $public;
            })
            ->addColumn('actions', function (Company $company) {
                $data['show_url'] = action('Admin\CompanyController@show', $company->id);
                $data['edit_url'] = action('Admin\CompanyController@edit', $company->id);
                $data['destroy_url'] = action('Admin\CompanyController@destroy', $company->id);
                $data['element_title'] = $company->name;
                $data['element_id'] = $company->id;

                return view('admin.index_actions', $data)->render();
            })
            ->make(true);
        return $out;
    }
}
