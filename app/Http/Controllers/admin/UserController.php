<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Form;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{

    public function index()
    {
        $elements = '
            <button class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal" 
                href="' . action('Admin\UserController@create') . '">
                    Ajouter un utilisateur
            </button>
        ';

        $config = [
            'var'         => 'utilisateur',
            'vars'        => 'utilisateurs',
            'description' => 'liste',
            'ajax_url'    => action('Admin\UserController@datatable'),
            'elements'    => $elements,
        ];
        $columns = [
            'Nom'        => 'full_name',
            'Email'      => 'email',
            'Entreprise' => 'company.name',
        ];
        return view('admin.index', compact('config', 'columns'));
    }


    public function create()
    {
        $config = [
            'title'     => 'Ajouter un utilisateur',
            'store_url' => action('Admin\UserController@store'),
        ];
        $fields = [
            [$field = 'first_name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'last_name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'phone', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'company_id', Form::select(
                $field,
                Company::pluck('name', 'id'),
                null,
                ['class' => 'form-control', 'rel' => 'select2']
            )],
            [$field = 'role', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'email', Form::email($field, null, ['class' => 'form-control'])],
            [$field = 'password', Form::password($field, ['class' => 'form-control'])],
            [$field = 'password_confirmation', Form::password($field, ['class' => 'form-control'])],
        ];

        return view('admin.create', compact('config', 'fields'));

    }


    public function store(Requests\UserStoreRequest $request)
    {
        $user = new User($request->all());
        $user->company_id = $request->input('company_id');
        $user->password = $request->input('password');
        $user->save();

        alert()->success($user->full_name.' créé avec succés.', 'C\'est tout bon !')->autoclose(7000);
        return;
    }


    public function show(User $user)
    {

        $config = [
            'var'         => 'utilisateur',
            'vars'        => 'utilisateurs',
            'description' => $user->full_name,
        ];
        Carbon::setLocale('fr');
        $columns = [
            'Prénom'        => $user->first_name,
            'Nom'           => $user->last_name,
            'Email'         => $user->email,
            'Télephone'     => $user->phone,
            'Entreprise'    => $user->company->name,
            'Fonction'      => $user->role,
            'Créé le'       => $user->created_at->toFormattedDateString(),
            'Mis à jour le' => $user->updated_at->toFormattedDateString(),
        ];
        return view('admin.show', compact('config', 'columns'));
    }


    public function edit(User $user)
    {
        $config = [
            'var'         => 'utilisateur',
            'vars'        => 'utilisateurs',
            'description' => $user->full_name,
            'update_url'  => action('Admin\UserController@update', $user->id),
            'cancel_url'  => action('Admin\UserController@index'),
        ];
        Form::setModel($user);

        $company_field = !\Auth::user()->is_admin ?
            Form::select('company_id', Company::pluck('name', 'id'), null, ['class' => 'form-control', 'rel' => 'select2']) :
            Form::text('company_name', $user->company->name, ['class' => 'form-control', 'disabled'])
        ;


        $fields = [
            [$field = 'first_name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'last_name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'phone', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'company_id', $company_field],
            [$field = 'role', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'email', Form::email($field, null, ['class' => 'form-control'])],
            [$field = 'password', Form::password($field, ['class' => 'form-control'])],
            [$field = 'password_confirmation', Form::password($field, ['class' => 'form-control'])],
        ];
        $object = $user;
        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(Requests\UserUpdateRequest $request, User $user)
    {
        $user->fill($request->all());

        if (\Auth::user()->is_admin && $request->has('company_id')) {
            $user->company_id = $request->input('company_id');
        }

        if ($request->has('password')) {
            $user->password = $request->input('password');
        }

        $user->save();

        alert()->success($user->full_name.' modifié avec succés.', 'C\'est tout bon !')->autoclose(7000);
        return redirect()->action('Admin\UserController@index');

    }

    public function destroy(User $user)
    {
        $user->delete();
        return;
    }

    public function datatable()
    {
        $users = User::with('company')->get();
        $out = Datatables::of($users)
            ->addColumn('actions', function (User $user) {
                $data['show_url'] = action('Admin\UserController@show', $user->id);
                $data['edit_url'] = action('Admin\UserController@edit', $user->id);
                $data['destroy_url'] = action('Admin\UserController@destroy', $user->id);
                $data['element_title'] = $user->full_name;
                $data['element_id'] = $user->id;

                return view('admin.index_actions', $data);
            })
            ->make(true);
        return $out;
    }
}
