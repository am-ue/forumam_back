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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elements = '
            <button class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#AddModal">
                    Ajouter un utilisateur
            </button>
        ';

        $config = [
            'var'         => 'utilisateur',
            'vars'        => 'utilisateurs',
            'description' => 'liste',
            'ajax_url'    => action('Admin\UserController@datatable'),
            'elements'    => '' /*$elements TODO pas encore de formulaire*/,
        ];
        $columns = [
            'Nom'        => 'full_name',
            'Email'      => 'email',
            'Entreprise' => 'company.name',
        ];
        return view('admin.index', compact('config', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
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
            'update_url' => action('Admin\UserController@update', $user->id),
            'cancel_url' => action('Admin\UserController@index'),
        ];
        Form::setModel($user);
        $fields = [
            'Prénom'        => [$field = 'first_name', Form::text($field, null, ['class' => 'form-control'])],
            'Nom'           => [$field = 'last_name', Form::text($field, null, ['class' => 'form-control'])],
            'Email'         => [$field = 'email', Form::email($field, null, ['class' => 'form-control'])],
            'Télephone'     => [$field = 'phone', Form::text($field, null, ['class' => 'form-control'])],
            'Entreprise'    => [$field = 'company_id',
                Form::select(
                    $field,
                    Company::pluck('name', 'id'),
                    null,
                    ['class' => 'form-control','rel' => 'select2']
                )
            ],
            'Fonction'      => [$field = 'role', Form::text($field, null, ['class' => 'form-control'])],
        ];
        $object = $user;
        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return 1;
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
