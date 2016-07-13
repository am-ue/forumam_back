<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Company;
use Auth;
use Carbon\Carbon;
use Form;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class CompanyController extends Controller
{

    public function index()
    {
        $elements = '
            <button class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal" 
                href="' . action('Admin\CompanyController@create') . '">
                    Ajouter une entreprise
            </button>
        ';

        $config = [
            'var'         => 'entreprise',
            'vars'        => 'entreprises',
            'description' => 'index',
            'ajax_url'    => action('Admin\CompanyController@datatable'),
            'elements'    => $elements,
        ];
        $columns = [
            'Nom'         => 'name',
            'Emplacement' => 'stand',
            'Categorie'   => 'category.name',
            'Contact'     => 'contact.full_name',

        ];
        return view('admin.index', compact('config', 'columns'));
    }


    public function create()
    {
        $config = [
            'title'     => 'Ajouter une entreprise',
            'store_url' => action('Admin\CompanyController@store'),
        ];
        $fields = [

            [$field = 'name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'website', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'description', Form::textarea($field, null, ['class' => 'form-control'])],
            [$field = 'billing_contact', Form::textarea($field, null, ['class' => 'form-control'])],
            [$field = 'billing_address', Form::textarea($field, null, ['class' => 'form-control'])],
            [$field = 'category_id', Form::select(
                $field,
                Category::pluck('name', 'id'),
                null,
                ['class' => 'form-control', 'rel' => 'select2']
            )],
        ];

        return view('admin.create', compact('config', 'fields'));

    }


    public function store(Requests\CompanyStoreRequest $request)
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
        return response();

    }


    public function show(Company $company)
    {

        $headerActions = '
            <a class="btn btn-default btn-sm pull-right" 
                href="' . action('Admin\CompanyController@edit', $company->id) . '">
                    Editer
            </a>
        ';
        $config = [
            'var'         => 'entreprise',
            'vars'        => 'entreprises',
            'description' => $company->name,
            'elements'    => $headerActions,
        ];

        Carbon::setLocale('fr');
        $fields = [
            'name'            => 'txt',
            'website'         => 'url',
            'description'     => 'txt',
            'figures'         => 'txt',
            'staffing'        => 'txt',
            'profiles'        => 'txt',
            'more'            => 'txt',
            'logo'            => 'img',
            'stand'           => 'txt',
            'billing_contact' => 'txt',
            'billing_address' => 'txt',
            'billing_delay'   => 'txt',
            'billing_method'  => 'txt',
            'category_id'     => link_to_route(
                'admin.users.show',
                $company->category->name,
                $company->category->id
            ),
            'active'          => 'bool',
            'public'          => 'bool',
            'created_at'      => 'date',
            'updated_at'      => 'date',
            'contact'         => link_to_route(
                'admin.users.show',
                $company->contact->full_name,
                $company->contact->id
            ),
        ];
        $object = $company;
        return view('admin.show', compact('config', 'fields', 'object'));
    }


    public function edit(Company $company)
    {
        $config = [
            'var'         => 'entreprise',
            'vars'        => 'entreprises',
            'description' => $company->name,
            'update_url'  => action('Admin\CompanyController@update', $company->id),
            'cancel_url'  => action('Admin\CompanyController@index'),
        ];
        Form::setModel($company);

        $fields = [
            [$field = 'name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'website', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'description', Form::textarea($field, null, ['class' => 'form-control'])],
            [$field = 'figures', Form::textarea($field, null, ['class' => 'form-control'])],
            [$field = 'staffing', Form::textarea($field, null, ['class' => 'form-control'])],
            [$field = 'profiles', Form::textarea($field, null, ['class' => 'form-control'])],
            [$field = 'more', Form::textarea($field, null, ['class' => 'form-control'])],
            [$field = 'logo', Form::file($field)],
            [$field = 'billing_contact', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'billing_address', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'billing_delay', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'billing_method', Form::select(
                $field,
                Company::$billing_methods,
                null,
                ['class' => 'form-control', 'rel' => 'select2']
            )],
            [$field = 'category_id', Form::select(
                $field,
                Category::pluck('name', 'id'),
                null,
                ['class' => 'form-control', 'rel' => 'select2']
            )],
        ];
        if (Auth::user()->is_admin && $company->id != 1) {
            $fields = array_merge($fields, [
                [$field = 'stand', Form::text($field, null, ['class' => 'form-control'])],
                [$field = 'active', Form::checkbox($field, null, null, ['rel' => 'switch'])],
                [$field = 'public', Form::checkbox($field, null, null, ['rel' => 'switch'])],
            ]);
        }
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
            $fileName = str_random().'.'.$extension;
            if ($request->file('logo')->move($destinationPath, $fileName)) {
                if (!empty($company->logo)) {
                    \File::delete(public_path($company->logo));
                }
                $company->logo = $destinationPath.$fileName;
            };
        }

        if (Auth::user()->is_admin) {
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
        if (Auth::user()->is_admin) {
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

    public function datatable()
    {
        $companies = Company::with('category')->get();
        $out = Datatables::of($companies)
            ->addColumn('actions', function (Company $company) {
                $data['show_url'] = action('Admin\CompanyController@show', $company->id);
                $data['edit_url'] = action('Admin\CompanyController@edit', $company->id);
                $data['destroy_url'] = action('Admin\CompanyController@destroy', $company->id);
                $data['element_title'] = $company->name;
                $data['element_id'] = $company->id;

                return view('admin.index_actions', $data);
            })
            ->make(true);
        return $out;
    }
}
