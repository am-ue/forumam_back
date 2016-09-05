<?php


namespace App\ViewsMakers;

use App\Models\Category;
use Form;

class CategoryViewsMaker extends ViewsMaker
{

    public function index()
    {
        $this->headerActions = [
            $this->headerActionModalButton(
                action('Admin\CategoryController@create'),
                "Ajouter une categorie"
            ),
        ];

        return $this;
    }

    public function create()
    {
        $this->fields = [
            $this->textField('name'),
            $this->textField('color', ['rel' => 'colorpicker']),
            $this->imageField('map'),
        ];

        return $this;
    }

    public function show(Category $category)
    {
        $this->model = $category;

        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\CategoryController@index'),
                "Revenir à la liste"
            ),
            $this->headerActionLinkButton(
                action('Admin\CategoryController@edit', $category->id),
                "Editer"
            ),
        ];


        $this->fields = [
            $this->showText('name'),
            $this->showCustom(
                'color',
                '<div style="background-color: ' . $category->color . '; width: 50px; height:50px"></div>'
            ),
            $this->showImage('map'),
            $this->showDate('created_at'),
            $this->showDate('updated_at'),
        ];

        return $this;
    }

    public function edit(Category $category)
    {
        $this->model = $category;


        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\CategoryController@index'),
                "Revenir à la liste"
            ),
            $this->headerActionLinkButton(
                action('Admin\CategoryController@show', $category->id),
                "Voir"
            ),
        ];

        Form::setModel($category);
        $this->fields = [
            $this->textField('name'),
            $this->textField('color', ['rel' => 'colorpicker']),
            $this->imageField('map'),
        ];

        return $this;
    }
}
