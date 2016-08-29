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
        return [$field, Form::text($field, $value, ['class' => 'form-control'] + $options)];
    }

    protected function selectField($field, $values, $options = [], $value = null)
    {
        return [$field, Form::select($field, $values, $value, [
                'class' => 'form-control',
                'rel' => 'select2'
            ] + $options)];
    }

    protected function passwordField($field, $options = [])
    {
        return [$field, Form::password($field, ['class' => 'form-control'] + $options)];
    }

    protected function showBoolean($attribute)
    {
        $data = [
            'bool' => $this->model->$attribute
        ];

        return [$attribute, view('admin.partials.showBoolean', $data)->render()];
    }

    protected function showUrl($attribute)
    {
        return [$attribute, link_to($this->model->$attribute)];
    }

    protected function showMailUrl($attribute)
    {
        return [$attribute, link_to('mailto:'.$this->model->$attribute, $this->model->$attribute)];
    }

    protected function showImage($attribute)
    {
        $data = [
            'src' => $this->model->$attribute,
            'alt' => $attribute
        ];

        return [$attribute, view('admin.partials.showImage', $data)->render()];
    }

    protected function showText($attribute)
    {
        return [$attribute, $this->model->$attribute];
    }

    protected function showDate($attribute)
    {
        return [$attribute, $this->model->$attribute->toFormattedDateString()];
    }

    protected function showRelationLink($relation, $relation_title_attribute, $action = null)
    {
        $action = $action ?: 'Admin\\'.Str::studly($relation).'Controller@show';
        return [
            $relation.'_id',
            link_to_action(
                $action,
                $this->model->$relation->$relation_title_attribute,
                $this->model->$relation->id
            )
        ];
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