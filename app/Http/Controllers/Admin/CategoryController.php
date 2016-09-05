<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\ViewsMakers\CategoryViewsMaker;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class CategoryController extends Controller
{

    public function index(CategoryViewsMaker $viewsMaker)
    {
        $config = [
            'var'         => 'catégorie',
            'vars'        => 'catégories',
            'description' => 'liste',
            'ajax_url'    => action('Admin\CategoryController@datatable'),
            'elements'    => $viewsMaker->index()->headerActions,
        ];
        $columns = [
            'Nom' => 'name',
            'Couleur' => 'color',
        ];
        return view('admin.index', compact('config', 'columns'));
    }


    public function create(CategoryViewsMaker $viewsMaker)
    {
        $config = [
            'title'     => 'Ajouter une catégorie',
            'store_url' => action('Admin\CategoryController@store'),
        ];
        $fields = $viewsMaker->create()->fields;

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


    public function show(Category $category, CategoryViewsMaker $viewsMaker)
    {

        $viewsMaker = $viewsMaker->show($category);

        $config = [
            'var'         => 'catégorie',
            'vars'        => 'catégories',
            'description' => $category->name,
            'elements'    => $viewsMaker->headerActions,
        ];

        $fields = $viewsMaker->fields;
        $object = $category;
        return view('admin.show', compact('config', 'fields', 'object'));
    }


    public function edit(Category $category, CategoryViewsMaker $viewsMaker)
    {
        $viewsMaker = $viewsMaker->edit($category);

        $config = [
            'var'         => 'catégorie',
            'vars'        => 'catégories',
            'description' => $category->name,
            'update_url'  => action('Admin\CategoryController@update', $category->id),
            'cancel_url'  => action('Admin\CategoryController@index'),
            'elements'    => $viewsMaker->headerActions,
        ];
        $fields = $viewsMaker->fields;
        $object = $category;

        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        $category->addMap($request);
        $category->save();

        alert()->success('<strong>' . $category->name . '</strong> a été modifiée avec succés.', 'C\'est tout bon !')
            ->html()->autoclose(7000);

        return redirect()->action('Admin\CategoryController@show', $category->id);
    }

    public function destroy(Category $category)
    {
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
}
