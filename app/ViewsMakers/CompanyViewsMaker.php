<?php


namespace App\ViewsMakers;

use App\Models\Category;
use App\Models\Company;
use Form;

class CompanyViewsMaker extends ViewsMaker
{

    public function index()
    {
        $this->headerActions = [
            $this->headerActionModalButton(
                action('Admin\CompanyController@create'),
                "Ajouter une entreprise"
            ),
        ];

        return $this;
    }

    public function create()
    {
        $this->fields = [
            $this->textField('name'),
            $this->textField('website'),
            $this->textField('summary'),
            $this->textareaField('description'),
            $this->textareaField('billing_contact'),
            $this->textareaField('billing_address'),
            $this->selectField('category_id', Category::pluck('name', 'id')),
        ];

        return $this;
    }

    public function show(Company $company)
    {
        $this->model = $company;

        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\CategoryController@index'),
                "Revenir à la liste"
            ),
            $this->headerActionLinkButton(
                action('Admin\CompanyController@edit', $company->id),
                "Editer"
            ),
        ];


        $this->fields = [
            $this->showText('name'),
            $this->showBoolean('active'),
            $this->showBoolean('public'),
            $this->showRelationLink('contact', 'full_name', 'Admin\UserController@show'),
            $this->showRelationLink('category', 'name'),
            $this->showUrl('website'),
            $this->showText('summary'),
            $this->showImage('logo'),
            $this->showText('stand'),
            $this->showText('description'),
            $this->showText('figures'),
            $this->showText('staffing'),
            $this->showText('profiles'),
            $this->showText('more'),
            $this->showText('billing_contact'),
            $this->showText('billing_address'),
            $this->showText('billing_delay'),
            $this->showText('billing_method'),
            $this->showDate('created_at'),
            $this->showDate('updated_at'),
        ];

        return $this;
    }

    public function edit(Company $company)
    {
        $this->model = $company;

        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\CompanyController@index'),
                "Revenir à la liste"
            ),
            $this->headerActionLinkButton(
                action('Admin\CompanyController@show', $company->id),
                "Voir"
            ),
        ];

        Form::setModel($company);

        $this->fields = [
            $this->textField('name'),
            $this->selectField('category_id', Category::pluck('name', 'id')),
            $this->textField('website'),
            $this->imageField('logo'),
            $this->textField('summary'),
            $this->textareaField('description'),
            $this->textareaField('figures'),
            $this->textareaField('staffing'),
            $this->textareaField('profiles'),
            $this->textareaField('more'),
            $this->textareaField('billing_contact'),
            $this->textareaField('billing_address'),
            $this->textareaField('billing_delay'),
            $this->selectField('billing_method', [] + Company::$billing_methods),
        ];

        if (auth()->user()->isAdmin() && $company->id != 1) {
            $this->fields = array_merge([
                $this->textField('stand'),
                $this->checkboxField('active'),
                $this->checkboxField('public'),
            ], $this->fields);
        }

        return $this;
    }
}
