<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigVariable;
use App\ViewsMakers\ConfigVariableViewsMaker;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ConfigVariableController extends Controller
{

    public function index(ConfigVariableViewsMaker $viewsMaker)
    {
        $config = [
            'var'         => 'texte',
            'vars'        => 'textes',
            'description' => 'liste',
            'ajax_url'    => action('Admin\ConfigVariableController@datatable'),
            'elements'    => $viewsMaker->index()->headerActions,
        ];
        $columns = [
            'Identifiant' => 'key',
            'Texte'       => 'value',
        ];
        return view('admin.index', compact('config', 'columns'));
    }


    public function create(ConfigVariableViewsMaker $viewsMaker)
    {
        $config = [
            'title'     => 'Ajouter un texte',
            'store_url' => action('Admin\ConfigVariableController@store'),
        ];
        $fields = $viewsMaker->create()->fields;

        return view('admin.create', compact('config', 'fields'));
    }


    public function store(Request $request)
    {
        /** @var ConfigVariable $configVariable */
        $configVariable = ConfigVariable::create($request->all());

        alert()->success('<strong>' . $configVariable->key . '</strong> a été créée avec succés.', 'C\'est tout bon !')
            ->html()->autoclose(7000);
        return;
    }


    public function show(ConfigVariable $config_variable, ConfigVariableViewsMaker $viewsMaker)
    {
        $configVariable = $config_variable;
        $viewsMaker = $viewsMaker->show($configVariable);

        $config = [
            'var'         => 'texte',
            'vars'        => 'textes',
            'description' => $configVariable->key,
            'elements'    => $viewsMaker->headerActions,
        ];

        $fields = $viewsMaker->fields;
        $object = $configVariable;
        return view('admin.show', compact('config', 'fields', 'object'));
    }


    public function edit(ConfigVariable $config_variable, ConfigVariableViewsMaker $viewsMaker)
    {
        $configVariable = $config_variable;
        $viewsMaker = $viewsMaker->edit($configVariable);

        $config = [
            'var'         => 'texte',
            'vars'        => 'textes',
            'description' => $configVariable->key,
            'update_url'  => action('Admin\ConfigVariableController@update', $configVariable->id),
            'cancel_url'  => action('Admin\ConfigVariableController@index'),
            'elements'    => $viewsMaker->headerActions,
        ];
        $fields = $viewsMaker->fields;
        $object = $configVariable;

        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(Request $request, ConfigVariable $config_variable)
    {
        $configVariable = $config_variable;
        $configVariable->update($request->all());
        $configVariable->save();

        alert()->success(
            '<strong>' . $configVariable->key . '</strong> a été modifiée avec succés.',
            'C\'est tout bon !'
        )->html()->autoclose(7000);

        return redirect()->action('Admin\ConfigVariableController@show', $configVariable->id);
    }

    public function destroy(ConfigVariable $config_variable)
    {
        $configVariable = $config_variable;
        $configVariable->delete();
        return;
    }

    public function datatable()
    {
        $configVariables = ConfigVariable::get();
        $out = Datatables::of($configVariables)
            ->addColumn('actions', function (ConfigVariable $configVariable) {
                $data['show_url'] = action('Admin\ConfigVariableController@show', $configVariable->id);
                $data['edit_url'] = action('Admin\ConfigVariableController@edit', $configVariable->id);
                $data['destroy_url'] = action('Admin\ConfigVariableController@destroy', $configVariable->id);
                $data['element_title'] = $configVariable->key;
                $data['element_id'] = $configVariable->id;

                return view('admin.index_actions', $data);
            })
            ->make(true);
        return $out;
    }
}
