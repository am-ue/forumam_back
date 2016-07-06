<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
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
        $config = [
            'var'        => 'utilisateur',
            'vars'        => 'utilisateurs',
            'preps' => ['de l\'', 'un'],
            'description'  => 'liste',
            'ajax_url' => route('admin.users.datatable')
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }

    public function datatable()
    {
        $users = User::with('company')->get();
        $out = Datatables::of($users)
            ->addColumn('actions', function (User $user) {
                $show_url = route('admin.users.show', $user->id);
                $edit_url = route('admin.users.edit', $user->id);
                $delete_form_open = Form::open([
                    'route'  => ['admin.users.destroy', $user->id],
                    'method' => 'delete',
                    'style'  => 'display:inline',
                ]);
                $delete_form_close = Form::close();
                return "
                    <div class='btn-group-xs'>
                        <a href='$show_url' class='btn btn-info'><i class='fa fa-eye'></i></a>
                        <a href='$edit_url' class='btn btn-warning'><i class='fa fa-edit'></i></a>
                        $delete_form_open
                            <button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-times'></i></button>
                        $delete_form_close
                    </div>
                ";
            })
            ->make(true);
        return $out;
    }
}
