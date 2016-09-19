<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\User;
use App\ViewsMakers\UserViewsMaker;
use Carbon\Carbon;
use Form;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{

    public function index(UserViewsMaker $viewsMaker)
    {
        $config = [
            'var'         => 'utilisateur',
            'vars'        => 'utilisateurs',
            'description' => 'liste',
            'ajax_url'    => action('Admin\UserController@datatable'),
            'elements'    => $viewsMaker->index()->headerActions,
        ];
        $columns = [
            'Nom'        => 'full_name',
            'Email'      => 'email',
            'Entreprise' => 'company.name',
        ];

        return view('admin.index', compact('config', 'columns'));
    }


    public function create(UserViewsMaker $viewsMaker)
    {
        $config = [
            'title'     => 'Ajouter un utilisateur',
            'store_url' => action('Admin\UserController@store'),
        ];
        $fields = $viewsMaker->create()->fields;

        return view('admin.create', compact('config', 'fields'));
    }


    public function store(Requests\UserStoreRequest $request)
    {
        $user = new User($request->all());
        $user->company_id = $request->input('company_id');
        $user->password = $request->input('password');
        $user->save();

        alert()->success($user->full_name . ' créé avec succés.', 'C\'est tout bon !')->autoclose(7000);
        return;
    }


    public function show(User $user, UserViewsMaker $viewsMaker)
    {
        $viewsMaker = $viewsMaker->show($user);

        $config = [
            'var'         => 'utilisateur',
            'vars'        => 'utilisateurs',
            'description' => $user->full_name,
            'elements'    => $viewsMaker->headerActions,
        ];
        $fields = $viewsMaker->fields;
        $object = $user;
        return view('admin.show', compact('config', 'fields', 'object'));
    }


    public function edit(User $user, UserViewsMaker $viewsMaker)
    {
        $viewsMaker = $viewsMaker->edit($user);

        $config = [
            'var'         => 'utilisateur',
            'vars'        => 'utilisateurs',
            'description' => $user->full_name,
            'update_url'  => action('Admin\UserController@update', $user->id),
            'cancel_url'  => action('Admin\UserController@index'),
            'elements'    => $viewsMaker->headerActions,

        ];

        $fields = $viewsMaker->fields;
        $object = $user;
        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(Requests\UserUpdateRequest $request, User $user)
    {
        $user->fill($request->all());

        if ($request->has('company_id')) {
            $user->company_id = $request->input('company_id');
        }

        if ($request->has('password')) {
            $user->password = $request->input('password');
        }

        $user->save();

        alert()->success($user->full_name . ' modifié avec succés.', 'C\'est tout bon !')->autoclose(7000);
        return redirect()->back();
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
            ->editColumn('company.name', function (User $user) {
                $company = $user->company;
                return (string) link_to_action('Admin\CompanyController@show', $company->name, $company->id);
            })
            ->editColumn('email', function (User $user) {
                return (string) link_to('mailto:'.$user->email, $user->email);
            })
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

    public function logAs(User $user = null)
    {
        if ($user->id) {
            Session::put('orig_user', auth()->id());
            auth()->login($user);
        } else {
            $id = Session::pull('orig_user');
            $orig_user = User::find($id);
            auth()->login($orig_user);
        }

        return redirect()->back();
    }
}
