<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\ViewsMakers\PostViewsMaker;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class PostController extends Controller
{

    public function index(PostViewsMaker $viewsMaker)
    {
        $config = [
            'var'         => 'actualité',
            'vars'        => 'actualités',
            'description' => 'liste',
            'ajax_url'    => action('Admin\PostController@datatable'),
            'elements'    => $viewsMaker->index()->headerActions,
        ];
        $columns = [
            'Titre'      => 'title',
            'Type'       => 'type',
            'Entreprise' => 'company.name',
            'Crée le'    => 'created_at',
        ];

        return view('admin.index', compact('config', 'columns'));
    }


    public function create(PostViewsMaker $viewsMaker)
    {
        $config = [
            'title'     => 'Ajouter une actualité',
            'store_url' => action('Admin\PostController@store'),
        ];
        $fields = $viewsMaker->create()->fields;

        return view('admin.create', compact('config', 'fields'));
    }


    public function store(PostRequest $request)
    {
        $post = new Post($request->all());
        $post->company_id = empty($request->input('company_id')) ? null : $request->input('company_id');
        switch ($request->input('type')) {
            case 'article':
                $post->addImg($request);
                break;
            case 'video':
                $post->youtube_id = $request->input('youtube_id');
                break;
        }
        $post->save();

        alert()->success($post->title . ' créé avec succés.', 'C\'est tout bon !')->autoclose(7000);
        return;
    }


    public function show(Post $post, PostViewsMaker $viewsMaker)
    {
        $viewsMaker = $viewsMaker->show($post);

        $config = [
            'var'         => 'actualité',
            'vars'        => 'actualités',
            'description' => $post->title,
            'elements'    => $viewsMaker->headerActions,
        ];
        $fields = $viewsMaker->fields;
        $object = $post;
        return view('admin.show', compact('config', 'fields', 'object'));
    }


    public function edit(Post $post, PostViewsMaker $viewsMaker)
    {
        $viewsMaker = $viewsMaker->edit($post);

        $config = [
            'var'         => 'actualité',
            'vars'        => 'actualités',
            'description' => $post->title,
            'update_url'  => action('Admin\PostController@update', $post->id),
            'cancel_url'  => action('Admin\PostController@index'),
            'elements'    => $viewsMaker->headerActions,

        ];

        $fields = $viewsMaker->fields;
        $object = $post;
        return view('admin.edit', compact('config', 'fields', 'object'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->fill($request->all());
        $post->company_id = empty($request->input('company_id')) ? null : $request->input('company_id');

        switch ($request->input('type')) {
            case 'article':
                $post->addImg($request);
                break;
            case 'video':
                $post->youtube_id = $request->input('youtube_id');
                break;
        }
        $post->save();

        alert()->success($post->title . ' modifié avec succés.', 'C\'est tout bon !')->autoclose(7000);
        return redirect()->action('Admin\PostController@show', $post->id);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return;
    }

    public function datatable()
    {
        $posts = Post::with('company')->get();
        $out = Datatables::of($posts)
            ->editColumn('company.name', function (Post $post) {
                $company = $post->company;
                return $company ?
                    (string)link_to_action('Admin\CompanyController@show', $company->name, $company->id) :
                    null;
            })
            ->addColumn('actions', function (Post $post) {
                $data['show_url'] = action('Admin\PostController@show', $post->id);
                $data['edit_url'] = action('Admin\PostController@edit', $post->id);
                $data['destroy_url'] = action('Admin\PostController@destroy', $post->id);
                $data['element_title'] = $post->title;
                $data['element_id'] = $post->id;

                return view('admin.index_actions', $data);
            })
            ->make(true);
        return $out;
    }
}
