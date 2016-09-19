<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Option;
use App\Models\OptionDetail;
use App\Models\Order;
use App\Models\User;
use App\ViewsMakers\OrderViewsMaker;
use Auth;
use Carbon\Carbon;
use Form;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
{

    public function index(OrderViewsMaker $viewsMaker, $company_id)
    {
        if (Order::count() == 0) {
            return redirect()->action('Admin\OrderController@edit', $company_id);
        }
        $config = [
            'var'         => 'commandes',
            'vars'        => 'commandes',
            'ajax_url'    => action('Admin\OrderController@datatable', ['company_id' => $company_id]),
            'elements'    => $viewsMaker->index($company_id)->headerActions,
        ];
        $columns = [
            ''  => 'id',
            'Option'  => 'option.name',
            'Valeur'  => 'labeled_value',
            'Total'    => 'price',
        ];
        return view('order_index', compact('config', 'columns', 'company_id'));
    }


    public function edit(OrderViewsMaker $viewsMaker, $company_id)
    {
        $config = [
            'var'         => 'Ma commande',
            'vars'        => 'commandes',
            'description' => 'Edition',
            'store_url'   => action('Admin\OrderController@store', ['company_id' => $company_id]),
            'elements'    => $viewsMaker->headerActions,
        ];

        return view('order_form', compact('config', 'company_id'));
    }


    public function store(Request $request, Company $company)
    {
        Order::whereCompanyId($company->id)->delete();
        foreach ($request->except('_token') as $option_id => $value) {
            if ($value == 0) {
                continue;
            }

            $option = Option::find($option_id);
            if ($option->type != 'select') {
                /** @var OptionDetail $detail */
                $detail = $option->details()->first();
                $price = $detail->price * $value;
            } else {
                $detail = $option->details()->find($value);
                $price = $detail->price;
            }
            $parent_option_id = $option_id;

            $company->orders()->create(compact('option_id', 'value', 'price', 'parent_option_id'));

            foreach ($detail->childrenRelations as $relation) {
                $company->orders()->create([
                    'option_id' => $relation->child->option_id,
                    'value' => $relation->child_value,
                    'price' => 0,
                    'parent_option_id' => $option_id,
                ]);
            }
        }
        alert()->success('Votre commande a été modifée avec succés.', 'Merci !')
            ->html()->autoclose(5000);
        return redirect()->action('Admin\OrderController@index', $company->id);
    }

    public function datatable($company_id)
    {
        $orders = Order::with('option')->get();
        $out = Datatables::of($orders)
            ->editColumn('price', function (Order $order) {
                if ($order->isAddedWithAnotherOrder()) {
                    /** @var OptionDetail $detail */
                    $detail = $order->parentOption->details()->find($order->value);
                    return 'Compris dans ' . $detail->label_with_option;
                }
                return $order->price . ' €';
            })
            ->editColumn('id', function (Order $order) use ($company_id) {
                return Order::whereCompanyId($company_id)->where('id', '<', $order->id)->count() + 1;
            })
            ->make(true);
        return $out;
    }
}
