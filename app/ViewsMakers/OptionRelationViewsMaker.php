<?php


namespace App\ViewsMakers;

use App\Models\Option;
use App\Models\OptionDetail;
use App\Models\OptionRelation;
use Form;

class OptionRelationViewsMaker extends ViewsMaker
{

    public function index()
    {
        $this->headerActions = [
            $this->headerActionModalButton(
                action('Admin\OptionRelationController@create'),
                "Ajouter une relation"
            ),
            $this->headerActionLinkButton(
                action('Admin\OptionController@index'),
                "Gérer les options"
            ),
        ];

        return $this;
    }

    public function create()
    {
        $options = OptionDetail::with('option')->get()->pluck('label_with_option', 'id');

        $this->fields = [
            $this->selectField('parent_id', $options),
            $this->numberField('parent_value', [], 1),
            $this->selectField('child_id', $options),
            $this->numberField('child_value', [], 1),
        ];

        return $this;
    }

    public function edit(OptionRelation $relation)
    {
        $this->model = $relation;


        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\OptionRelationController@index'),
                "Revenir à la liste"
            ),
        ];

        Form::setModel($relation);

        $options = OptionDetail::with('option')->get()->pluck('label_with_option', 'id');
        $this->fields = [
            $this->selectField('parent_id', $options),
            $this->numberField('parent_value'),
            $this->selectField('child_id', $options),
            $this->numberField('child_value'),
        ];

        return $this;
    }
}
