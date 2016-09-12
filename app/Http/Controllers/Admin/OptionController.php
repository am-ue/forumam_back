<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OptionRequest;
use App\Models\Option;
use App\Models\OptionDetail;
use App\Models\OptionRelation;
use App\ViewsMakers\OptionViewsMaker;
use Carbon\Carbon;
use Form;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class OptionController extends Controller
{

    public function index(OptionViewsMaker $viewsMaker)
    {
        $config = [
            'var'         => 'option',
            'vars'        => 'options',
            'description' => 'index',
            'ajax_url'    => action('Admin\OptionController@datatable'),
            'reorder_url'    => action('Admin\OptionController@reorder'),
            'elements'    => $viewsMaker->index()->headerActions,
        ];
        $columns = [
            'Classement' => 'order',
            'Nom'  => 'name',
            'Type' => 'type',
            'Prix' => 'price',
        ];
        return view('admin.index', compact('config', 'columns'));
    }


    public function create(OptionViewsMaker $viewsMaker)
    {
        $config = [
            'title'     => 'Ajouter une option',
            'store_url' => action('Admin\OptionController@store'),
        ];
        $fields = $viewsMaker->create()->fields;

        return view('admin.create', compact('config', 'fields'));
    }


    public function store(OptionRequest $request)
    {
        $option = new Option($request->all());
        $option->order = Option::count() + 1;
        if ($option->type == 'select') {
            $details = [];
            foreach ($request->input('label') as $id => $label) {
                $price = $request->input('price')[$id];
                if (!empty($label) && !empty($price)) {
                    $details[] = new OptionDetail(['label' => $label, 'price' => $price]);
                }
            }
            if (count($details) < 2) {
                return response()->json(
                    ['label[]' => [
                        'Merci de mettre au moins deux choix pour le menu, ou de selectionner un autre type de champ'
                    ]],
                    422
                );
            }
            $option->save();
            $option->details()->saveMany($details);
        } else {
            $option->save();
            $option->details()->save(new OptionDetail(['price' => $request->input('price')]));
        }

        alert()->success('<strong>' . $option->name . '</strong> a été créée avec succés.', 'C\'est tout bon !')
            ->html()->autoclose(7000);
        return;
    }


    public function show(Option $option)
    {
        return redirect()->action('Admin\OptionController@edit', $option->id);
    }

    public function edit(Option $option, OptionViewsMaker $viewsMaker)
    {
        $viewsMaker = $viewsMaker->edit($option);

        $config = [
            'var'         => 'option',
            'vars'        => 'options',
            'description' => $option->name,
            'update_url'  => action('Admin\OptionController@update', $option->id),
            'cancel_url'  => action('Admin\OptionController@index'),
            'elements'    => $viewsMaker->headerActions,
        ];

        $fields = $viewsMaker->fields;
        $object = $option;

        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(OptionRequest $request, Option $option)
    {
        if ($option->childrenRelations()->count() or $option->parentsRelations()->count()) {
            alert()->error('Il reste des relations attachées à cette option,
                        merci de les supprimer avant de la modifier.', 'Attention')->persistent();
            return redirect()->action('Admin\OptionRelationController@index');
        };

        $option->fill($request->all());
        if ($option->type == 'select') {
            $details = [];
            foreach ($request->input('label') as $id => $label) {
                $price = $request->input('price')[$id];
                if (!empty($label) && !empty($price)) {
                    $details[] = new OptionDetail(['label' => $label, 'price' => $price]);
                }
            }
            if (count($details) < 2) {
                return redirect()->back()
                    ->withErrors(['price' => 'Merci de mettre au moins deux choix pour le menu, 
                    ou de selectionner un autre type de champ']);
            }
            OptionDetail::whereOptionId($option->id)->delete();
            $option->details()->saveMany($details);
        } else {
            OptionDetail::whereOptionId($option->id)->delete();
            $option->details()->save(new OptionDetail(['price' => $request->input('price')]));
        }
        $option->save();

        alert()->success('<strong>' . $option->name . '</strong> a été modifiée avec succés.', 'C\'est tout bon !')
            ->html()->autoclose(7000);

        return redirect()->action('Admin\OptionController@index');
    }

    public function destroy(Option $option)
    {
        if ($option->childrenRelations()->count() or $option->parentsRelations()->count()) {
            return response()->json([
                'type' => 'error',
                'message' => 'Il reste des relations attachées à cette option,
                        merci de les supprimer d\'abord.',
                'title'=> 'Attention'
            ], 400);
        }
        return $option->delete();
    }

    public function reorder(Request $request)
    {
        $changes = array_pluck($request->all(), 'newData', 'oldData');

        $options_to_change = Option::whereIn('order', array_keys($changes))->get();
        foreach ($options_to_change as $option) {
            $option->update(['order' => $changes[$option->order]]);
        };
        return;
    }

    public function datatable()
    {
        $options = Option::get();
        $out = Datatables::of($options)
            ->addColumn('actions', function (Option $option) {
                $data['show_url'] = action('Admin\OptionController@show', $option->id);
                $data['edit_url'] = action('Admin\OptionController@edit', $option->id);
                $data['destroy_url'] = action('Admin\OptionController@destroy', $option->id);
                $data['element_title'] = $option->name;
                $data['element_id'] = $option->id;

                return view('admin.index_actions', $data);
            })
            ->editColumn('price', function (Option $option) {
                $return = '';
                foreach ($option->details as $detail) {
                    $return .= $detail->price . '€';
                    if ($option->type == 'select') {
                        $return .= ' (' . $detail->label . '), ';
                    }
                }
                return rtrim($return, ', ');
            })
            ->editColumn('type', function (Option $option) {
                return Option::$types[$option->type];
            })
            ->make(true);
        return $out;
    }
}
