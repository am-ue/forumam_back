<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OptionRequest;
use App\Models\Option;
use App\Models\OptionDetail;
use Carbon\Carbon;
use Form;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class OptionController extends Controller
{

    public function index()
    {
        $elements = '
            <button class="btn btn-default btn-sm pull-right" data-toggle="modal" 
                data-target="#modal" href="' . action('Admin\OptionController@create') . '">
                    Ajouter une option
            </button>
            <a class="btn btn-default btn-sm pull-right" style="margin-right:5px" 
                href="' . route('admin.option-relations.index') . '">
                    Gérer les relations
            </a>
        ';

        $config = [
            'var'         => 'option',
            'vars'        => 'options',
            'description' => 'index',
            'ajax_url'    => action('Admin\OptionController@datatable'),
            'elements'    => $elements,
        ];
        $columns = [
            'Nom'  => 'name',
            'Type' => 'type',
            'Prix' => 'price',
        ];
        return view('admin.index', compact('config', 'columns'));
    }


    public function create()
    {
        $config = [
            'title'     => 'Ajouter une option',
            'store_url' => action('Admin\OptionController@store'),
        ];
        $fields = [
            [$field = 'name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'type', Form::select($field, ['' => ''] + Option::$types, null, [
                'class' => 'form-control script-option',
            ])],
            [$field = 'price', '<div id="price" class="script-option">Merci de choisir un type.</div>'],
        ];

        return view('admin.create', compact('config', 'fields'));
    }


    public function store(OptionRequest $request)
    {
        $option = Option::create($request->all());
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

    public function edit(Option $option)
    {
        $headerActions = '
            <a class="btn btn-default btn-sm pull-right" 
                href="' . action('Admin\OptionController@show', $option->id) . '">
                    Voir
            </a>
        ';
        $config = [
            'var'         => 'option',
            'vars'        => 'options',
            'description' => $option->name,
            'update_url'  => action('Admin\OptionController@update', $option->id),
            'cancel_url'  => action('Admin\OptionController@index'),
            'elements'    => $headerActions,
        ];
        Form::setModel($option);

        $row_class = '';
        if ($option->type == 'select') {
            $row_class = 'row';
            $inputs = '<div class="col-xs-12" style="margin-bottom: 5px;">
                <button type="button" class="btn btn-xs btn-default script-option add_price">
                    Ajouter une ligne (laisser vide pour supprimer)
                </button>
            </div>';
            foreach ($option->details as $detail) {
                $inputs .= "<div class='col-sm-8' style='margin-bottom: 5px;'>
                    <input class='form-control' name='label[]' value='$detail->label' placeholder='Label' type='text'>
                </div>
                <div class='col-sm-4'>
                    <input class='form-control' placeholder='Prix' value='$detail->price' 
                           name='price[]' type='number' step='0.01'>
                </div>";
            }
        } else {
            $inputs = "<input class='form-control' name='price' value='$option->details->price'
 type='number' step='0.01'>";
        }
        $fields = [
            [$field = 'name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'type', Form::select($field, ['' => ''] + Option::$types, null, [
                'class' => 'form-control script-option',
            ])],
            [$field = 'price',"<div id='price' class='script-option $row_class'>$inputs</div>"],
        ];
        $object = $option;

        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(OptionRequest $request, Option $option)
    {
        $option->update($request->all());
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
            $option->details()->save(new OptionDetail(['price' => $request->input('price')]));
        }

        alert()->success('<strong>' . $option->name . '</strong> a été modifiée avec succés.', 'C\'est tout bon !')
            ->html()->autoclose(7000);

        return redirect()->action('Admin\OptionController@show', $option->id);
    }

    public function destroy(Option $option)
    {
        $option->delete();
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
