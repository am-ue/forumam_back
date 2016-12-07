<?php


namespace App\ViewsMakers;

use App\Models\Company;
use App\Models\Post;
use Form;

class PostViewsMaker extends ViewsMaker
{

    public function index()
    {
        $this->headerActions = [
            $this->headerActionModalButton(
                action('Admin\PostController@create'),
                "Ajouter une actualité"
            ),
        ];

        return $this;
    }

    public function create()
    {
        $this->fields = [
            $this->textField('title'),
            $this->textareaField('description'),
            $this->selectField('type', Post::$types),
            $this->selectField('company_id', [null => "Aucune"] + Company::pluck('name', 'id')->toArray()),
            $this->textField('youtube_id'),
            $this->imageField('img'),
        ];

        return $this;
    }

    public function show(Post $post)
    {
        $this->model = $post;

        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\PostController@index'),
                "Revenir à la liste"
            ),
            $this->headerActionLinkButton(
                action('Admin\PostController@edit', $post->id),
                "Editer"
            ),
        ];



        $this->fields = array_filter([
            $this->showText('title'),
            $this->showText('description'),
            $this->showCustom('type', Post::$types[$post->type]),
            $post->company ? $this->showRelationLink('company', 'name') : null,
            $post->type == 'article' ? $this->showImage('img') : null,
            $post->type == 'video' ? $this->showUrl('youtube_url') : null,
            $post->type == 'video' ? $this->showImage('youtube_thumb') : null,
        ]);

        return $this;
    }

    public function edit(Post $post)
    {
        $this->model = $post;


        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\PostController@index'),
                "Revenir à la liste"
            ),
            $this->headerActionLinkButton(
                action('Admin\PostController@show', $post->id),
                "Voir"
            ),
        ];

        Form::setModel($post);

        $this->fields = [
            $this->textField('title'),
            $this->textareaField('description'),
            $this->selectField('type', Post::$types),
            $this->selectField('company_id', [null => "Aucune"] + Company::pluck('name', 'id')->toArray()),
            $this->textField('youtube_id'),
            $this->imageField('img'),
        ];

        return $this;
    }
}
