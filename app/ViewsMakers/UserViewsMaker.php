<?php


namespace App\ViewsMakers;

use App\Models\Company;
use App\Models\User;
use Form;

class UserViewsMaker extends ViewsMaker
{

    public function index()
    {
        $this->headerActions = [
            $this->headerActionModalButton(
                action('Admin\UserController@create'),
                "Ajouter un utilisateur"
            ),
        ];

        return $this;
    }

    public function create()
    {
        $this->fields = [
            $this->textField('first_name'),
            $this->textField('last_name'),
            $this->textField('phone'),
            $this->selectField('company_id', Company::pluck('name', 'id')),
            $this->textField('role'),
            $this->textField('email'),
            $this->passwordField('password'),
            $this->passwordField('password_confirmation'),
        ];

        return $this;
    }

    public function show(User $user)
    {
        $this->model = $user;

        $headerActions = [
            $this->headerActionLinkButton(
                action('Admin\UserController@edit', $user->id),
                "Editer"
            ),
        ];

        if (auth()->user()->isAdmin()) {
            $headerActions[] = $this->headerActionLinkButton(
                action('Admin\UserController@logAs', $user),
                "Se connecter en tant que"
            );
        }

        $this->headerActions = $headerActions;


        $this->fields = [
            $this->showText('first_name'),
            $this->showText('last_name'),
            $this->showMailUrl('email'),
            $this->showText('phone'),
            $this->showRelationLink('company', 'name'),
            $this->showText('role'),
            $this->showDate('created_at'),
            $this->showDate('updated_at'),
        ];

        return $this;
    }

    public function edit(User $user)
    {
        $this->model = $user;


        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\UserController@index'),
                "Revenir à la liste"
            ),
            $this->headerActionLinkButton(
                action('Admin\UserController@show', $user->id),
                "Voir"
            ),
        ];

        Form::setModel($user);
        $company_field = auth()->user()->isAdmin() ?
            $this->selectField('company_id', Company::pluck('name', 'id')) :
            $this->textField('company_name', ['disabled'], $user->company->name);

        $this->fields = [
            $this->textField('first_name'),
            $this->textField('last_name'),
            $this->textField('phone'),
            $company_field,
            $this->textField('role'),
            $this->textField('email'),
            $this->passwordField('password'),
            $this->passwordField('password_confirmation'),
        ];

        return $this;
    }
}
