<?php


namespace App\ViewsMakers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Option;
use App\Models\OptionDetail;
use App\Models\Order;
use Form;

class BadgeViewsMaker extends ViewsMaker
{
    public function index($company)
    {
        $this->headerActions = [

        ];

        return $this;
    }

    public function edit()
    {
        $adminHeaderActions = [
            $this->headerActionLinkButton(
                action('Admin\OrderController@index'),
                "Revenir"
            ),
        ];

        $this->headerActions = auth()->user()->isAdmin() ? $adminHeaderActions : [];

        return $this;
    }
}
