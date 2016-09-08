<?php


namespace App\ViewsMakers;

use Form;
use Illuminate\Support\Str;

/**
 * App\ViewsMakers\ViewsMaker;
 *
 * @property array $headerActions
 * @property array $fields
 * @property string $model
 */

abstract class ViewsMaker
{
    private $model;
    private $headerActions;
    private $fields;

    /**
     * @param array $headerActions
     */
    public function setHeaderActions($headerActions)
    {
        $this->headerActions = implode('', $headerActions);
    }

    protected function headerActionModalButton($href, $text)
    {
        return view('admin.partials.headerActionModalButton', compact('href', 'text'))->render();
    }

    protected function headerActionLinkButton($href, $text)
    {
        return view('admin.partials.headerActionLinkButton', compact('href', 'text'))->render();
    }

    protected function textField($field, $options = [], $value = null)
    {
        return [$field, Form::text($field, $value, $options + ['class' => 'form-control'])];
    }

    protected function numberField($field, $options = [], $value = null)
    {
        return [$field, Form::number($field, $value, $options + ['class' => 'form-control'])];
    }


    protected function checkboxField($field, $options = [], $value = null)
    {
        return [$field, Form::checkbox($field, 1, $value, $options + ['rel' => 'switch'])];
    }

    protected function imageField($field, $options = [])
    {
        return [$field, Form::file($field, $options)];
    }

    protected function textareaField($field, $options = [], $value = null)
    {
        return [$field, Form::textarea($field, $value, $options + ['class' => 'form-control'])];
    }

    protected function selectField($field, $values, $options = [], $value = null)
    {
        return [$field, Form::select($field, $values, $value, $options + [
                'class' => 'form-control',
                'rel'   => 'select2',
            ])];
    }

    protected function passwordField($field, $options = [])
    {
        return [$field, Form::password($field, $options + ['class' => 'form-control'])];
    }

    protected function showBoolean($attribute)
    {
        return [$attribute, $this->badgeHelper($this->model->$attribute, 'Oui', 'Non')];
    }

    protected function showUrl($attribute)
    {
        return [$attribute, link_to($this->model->$attribute)];
    }

    protected function showMailUrl($attribute)
    {
        return [$attribute, link_to('mailto:' . $this->model->$attribute, $this->model->$attribute)];
    }

    protected function showImage($attribute)
    {
        $data = [
            'src' => $this->model->$attribute,
            'alt' => $attribute,
        ];

        return [$attribute, view('admin.partials.showImage', $data)->render()];
    }

    protected function showText($attribute)
    {
        return [$attribute, $this->model->$attribute];
    }

    protected function showCustom($label, $custom)
    {
        return [$label, $custom];
    }

    protected function showDate($attribute)
    {
        return [$attribute, $this->model->$attribute->toFormattedDateString()];
    }

    protected function showRelationLink($relation, $relation_title_attribute, $action = null)
    {
        $action = $action ?: 'Admin\\' . Str::studly($relation) . 'Controller@show';
        return [
            $relation . '_id',
            link_to_action(
                $action,
                $this->model->$relation->$relation_title_attribute,
                $this->model->$relation->id
            ),
        ];
    }

    public function badgeHelper($boolean, $true, $false)
    {
        return view('admin.partials.showBoolean', compact('boolean', 'true', 'false'))->render();
    }

    public function __get($key)
    {
        return $this->$key;
    }

    public function __set($key, $value)
    {
        $setter = 'set' . Str::studly($key);
        if (method_exists($this, $setter)) {
            return $this->{$setter}($value);
        }

        return $this->$key = $value;
    }
}
