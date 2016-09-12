<?php


namespace App\ViewsMakers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Option;
use App\Models\OptionDetail;
use App\Models\Order;
use Form;

class OrderViewsMaker extends ViewsMaker
{
    public function index($company)
    {
        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\OrderController@edit', $company),
                "Editer"
            )
        ];

        return $this;
    }

    public function edit()
    {
        $this->headerActions = [
            $this->headerActionLinkButton(
                action('Admin\OrderController@index'),
                "Voir"
            ),
        ];

        return $this;
    }
}
