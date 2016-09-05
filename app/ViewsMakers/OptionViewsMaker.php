<?php


namespace App\ViewsMakers;

use App\Models\Option;
use Form;

class OptionViewsMaker extends ViewsMaker
{

    public function index()
    {
        $this->headerActions = [
            $this->headerActionModalButton(
                action('Admin\OptionController@create'),
                "Ajouter une option"
            ),
            $this->headerActionLinkButton(
                action('Admin\OptionRelationController@index'),
                "Gérer les relations"
            ),
        ];

        return $this;
    }

    public function create()
    {
        $this->fields = [
            $this->textField('name'),
            $this->selectField('type', ['' => ''] + Option::$types, ['class' => 'script-option form-control']),
            $this->showCustom('price', '<div id="price" class="script-option">Merci de choisir un type.</div>'),
        ];

        return $this;
    }

    public function edit(Option $option)
    {
        $this->model = $option;


        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\OptionController@index'),
                "Revenir à la liste"
            ),
        ];

        Form::setModel($option);
        $this->fields = [
            $this->textField('name'),
            $this->selectField('type', ['' => ''] + Option::$types, ['class' => 'script-option form-control']),
            [$field = 'price', view('partials.price_details', compact('option'))->render()],
        ];

        return $this;
    }
}
