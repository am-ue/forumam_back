<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Carbon\Carbon;
use Form;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class CategoryController extends Controller
{

    public function index()
    {
        $elements = '
            <button class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modal" 
                href="' . action('Admin\CategoryController@create') . '">
                    Ajouter une catégorie
            </button>
        ';

        $config = [
            'var'         => 'catégorie',
            'vars'        => 'catégories',
            'description' => 'index',
            'ajax_url'    => action('Admin\CategoryController@datatable'),
            'elements'    => $elements,
        ];
        $columns = [
            'Nom' => 'name',
            'Couleur' => 'color',
        ];
        return view('admin.index', compact('config', 'columns'));
    }


    public function create()
    {
        $config = [
            'title'     => 'Ajouter une catégorie',
            'store_url' => action('Admin\CategoryController@store'),
        ];
        $fields = [
            [$field = 'name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'color', Form::text($field, null, ['class' => 'form-control', 'rel' => 'colorpicker'])],
            [$field = 'map', Form::file($field)],
        ];

        return view('admin.create', compact('config', 'fields'));

    }


    public function store(CategoryRequest $request)
    {
        $category = new Category($request->all());
        $this->uploadMap($request, $category);
        $category->save();

        alert()->success('<strong>' . $category->name . '</strong> a été créée avec succés.', 'C\'est tout bon !')
            ->html()->autoclose(7000);
        return;
    }


    public function show(Category $category)
    {

        $headerActions = '
            <a class="btn btn-default btn-sm pull-right" 
                href="' . action('Admin\CategoryController@edit', $category->id) . '">
                    Editer
            </a>
        ';
        $config = [
            'var'         => 'catégorie',
            'vars'        => 'catégories',
            'description' => $category->name,
            'elements'    => $headerActions,
        ];

        Carbon::setLocale('fr');
        $fields = [
            'name'  => 'txt',
            'color' => '<div style="background-color: ' . $category->color . '; width: 50px; height:50px"></div>',
            'map'   => 'img',
            'created_at'      => 'date',
            'updated_at'      => 'date',
        ];
        $object = $category;
        return view('admin.show', compact('config', 'fields', 'object'));
    }


    public function edit(Category $category)
    {
        $headerActions = '
            <a class="btn btn-default btn-sm pull-right" 
                href="' . action('Admin\CategoryController@show', $category->id) . '">
                    Voir
            </a>
        ';
        $config = [
            'var'         => 'catégorie',
            'vars'        => 'catégories',
            'description' => $category->name,
            'update_url'  => action('Admin\CategoryController@update', $category->id),
            'cancel_url'  => action('Admin\CategoryController@index'),
            'elements'    => $headerActions,
        ];
        Form::setModel($category);

        $fields = [
            [$field = 'name', Form::text($field, null, ['class' => 'form-control'])],
            [$field = 'color', Form::text($field, null, ['class' => 'form-control', 'rel' => 'colorpicker'])],
            [$field = 'map', Form::file($field)],
        ];
        $object = $category;

        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        $this->uploadMap($request, $category);
        $category->save();

        alert()->success('<strong>' . $category->name . '</strong> a été modifiée avec succés.', 'C\'est tout bon !')
            ->html()->autoclose(7000);

        return redirect()->action('Admin\CategoryController@show');
    }

    public function destroy(Category $category)
    {
        \File::delete(public_path($category->map));
        $category->delete();
        return;
    }

    public function datatable()
    {
        $categories = Category::get();
        $out = Datatables::of($categories)
            ->addColumn('actions', function (Category $category) {
                $data['show_url'] = action('Admin\CategoryController@show', $category->id);
                $data['edit_url'] = action('Admin\CategoryController@edit', $category->id);
                $data['destroy_url'] = action('Admin\CategoryController@destroy', $category->id);
                $data['element_title'] = $category->name;
                $data['element_id'] = $category->id;

                return view('admin.index_actions', $data);
            })
            ->editColumn('color', function (Category $category) {
                return '<div style="background-color: ' . $category->color . '; width: 20px; height:20px"></div>';
            })
            ->make(true);
        return $out;
    }

    protected function uploadMap(CategoryRequest $request, Category $category)
    {
        if ($request->hasFile('map') && $request->file('map')->isValid()) {
            $map = $request->file('map');
            $destinationPath = Category::UPLOAD_PATH;
            $extension = $map->getClientOriginalExtension();
            $fileName = str_random() . '.' . $extension;
            if ($request->file('map')->move($destinationPath, $fileName)) {
                if (!empty($category->map)) {
                    \File::delete(public_path($category->map));
                }
                $category->map = $destinationPath . $fileName;
            };
        }
    }
}
