<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OptionRelationRequest;
use App\Models\OptionRelation;
use App\ViewsMakers\OptionRelationViewsMaker;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class OptionRelationController extends Controller
{

    public function index(OptionRelationViewsMaker $viewsMaker)
    {
        $config = [
            'var'         => 'relation',
            'vars'        => 'relations',
            'description' => 'index',
            'ajax_url'    => action('Admin\OptionRelationController@datatable'),
            'elements'    => $viewsMaker->index()->headerActions,
        ];
        $columns = [
            'Parent'  => 'parent.label_with_all',
            'Qté (condition)' => 'parent_value',
            'Enfant' => 'child.label_with_all',
            'Qté (résultat)' => 'child_value',
        ];
        return view('admin.index', compact('config', 'columns'));
    }


    public function create(OptionRelationViewsMaker $viewsMaker)
    {
        $config = [
            'title'     => 'Ajouter une relation',
            'store_url' => action('Admin\OptionRelationController@store'),
        ];
        $fields = $viewsMaker->create()->fields;

        return view('admin.create', compact('config', 'fields'));
    }


    public function store(OptionRelationRequest $request)
    {
        $relation = OptionRelation::create($request->all());


        alert()->success(
            'La relation <strong>' . $relation->name . '</strong> a été créée avec succés.',
            'C\'est tout bon !'
        )->html()->autoclose(7000);
        return;
    }


    public function show(OptionRelation $relation)
    {
        return redirect()->action('Admin\OptionRelationController@edit', $relation->id);
    }

    public function edit(OptionRelation $relation, OptionRelationViewsMaker $viewsMaker)
    {
        $viewsMaker = $viewsMaker->edit($relation);

        $config = [
            'var'         => 'relation',
            'vars'        => 'relations',
            'description' => $relation->name,
            'update_url'  => action('Admin\OptionRelationController@update', $relation->id),
            'cancel_url'  => action('Admin\OptionRelationController@index'),
            'elements'    => $viewsMaker->headerActions,
        ];

        $fields = $viewsMaker->fields;
        $object = $relation;

        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(OptionRelationRequest $request, OptionRelation $relation)
    {
        $relation->update($request->all());

        alert()->success(
            'La relation <strong>' . $relation->name . '</strong> a été modifiée avec succés.',
            'C\'est tout bon !'
        )->html()->autoclose(7000);

        return redirect()->action('Admin\OptionRelationController@index');
    }

    public function destroy(OptionRelation $relation)
    {
        $relation->delete();
        return;
    }

    public function datatable()
    {
        $relations = OptionRelation::with('parent', 'child')->get();
        $out = Datatables::of($relations)
            ->addColumn('actions', function (OptionRelation $relation) {
                $data['show_url'] = action('Admin\OptionRelationController@show', $relation->id);
                $data['edit_url'] = action('Admin\OptionRelationController@edit', $relation->id);
                $data['destroy_url'] = action('Admin\OptionRelationController@destroy', $relation->id);
                $data['element_title'] = $relation->name;
                $data['element_id'] = $relation->id;

                return view('admin.index_actions', $data);
            })
            ->make(true);
        return $out;
    }
}
