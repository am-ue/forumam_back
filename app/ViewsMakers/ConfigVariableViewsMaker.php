<?php

namespace App\ViewsMakers;

use App\Models\ConfigVariable;
use Form;
use GrahamCampbell\Markdown\Facades\Markdown;
use League\CommonMark\Converter;

class ConfigVariableViewsMaker extends ViewsMaker
{

    protected $markdown;

    public function __construct(Converter $converter)
    {
        $this->markdown = $converter;
    }

    public function index()
    {
        $this->headerActions = [
            $this->headerActionModalButton(
                action('Admin\ConfigVariableController@create'),
                "Ajouter un texte"
            ),
        ];

        return $this;
    }

    public function create()
    {
        $this->fields = [
            $this->textField('key'),
            $this->textareaField('value'),
        ];

        return $this;
    }

    public function show(ConfigVariable $configVariable)
    {
        $this->model = $configVariable;

        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\ConfigVariableController@index'),
                "Revenir à la liste"
            ),
            $this->headerActionLinkButton(
                action('Admin\ConfigVariableController@edit', $configVariable->id),
                "Editer"
            ),
        ];


        $this->fields = [
            $this->showText('key'),
            $this->showCustom('value', $this->markdown->convertToHtml($configVariable->value)),
        ];

        return $this;
    }

    public function edit(ConfigVariable $configVariable)
    {
        $this->model = $configVariable;


        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\ConfigVariableController@index'),
                "Revenir à la liste"
            ),
            $this->headerActionLinkButton(
                action('Admin\ConfigVariableController@show', $configVariable->id),
                "Voir"
            ),
        ];

        Form::setModel($configVariable);
        $this->fields = [
            $this->textField('key'),
            $this->textareaField('value'),
        ];

        return $this;
    }
}
