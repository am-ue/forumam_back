<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Company;
use App\Models\OptionDetail;
use App\Models\Order;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class DownloadController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function companies()
    {
        $companies = Company::with(['users', 'category'])->get()->map(function (Company $company) {
            return [
                trans('validation.attributes.name') => $company->name,
                trans('validation.attributes.website') => $company->website,
                trans('validation.attributes.description') => $company->description,
                trans('validation.attributes.summary') => $company->summary,
                trans('validation.attributes.figures') => $company->figures,
                trans('validation.attributes.staffing') => $company->staffing,
                trans('validation.attributes.profiles') => $company->profiles,
                trans('validation.attributes.more') => $company->more,
                trans('validation.attributes.logo') => asset($company->logo),
                trans('validation.attributes.stand') => $company->stand,
                trans('validation.attributes.billing_contact') => $company->billing_contact,
                trans('validation.attributes.billing_address') => $company->billing_address,
                trans('validation.attributes.billing_delay') => $company->billing_delay,
                trans('validation.attributes.billing_method') => $company->billing_method,
                trans('validation.attributes.category_id') => $company->category->name,
                trans('validation.attributes.active') => $company->active ? 'Oui' : 'Non',
                trans('validation.attributes.public') => $company->public ? 'Oui' : 'Non',
                trans('validation.attributes.user.first_name') => $company->contact->first_name,
                trans('validation.attributes.user.last_name') => $company->contact->last_name,
                trans('validation.attributes.user.phone') => $company->contact->phone,
                trans('validation.attributes.user.email') => $company->contact->email,
                trans('validation.attributes.created_at') => $company->created_at,
                trans('validation.attributes.updated_at') => $company->updated_at,
            ];
        });
        return $this->exportExcel('Entreprises', $companies);
    }

    public function products()
    {
        $products = OptionDetail::with(['option', 'option.orders'])->get()->map(function (OptionDetail $detail) {
                $orders = $detail->option->orders;
                $qty = $detail->option->type != 'select' ?
                    $orders->sum('value') :
                    $orders->where('value', $detail->id)->count();

                return [
                    'Produits' => $detail->label_with_all,
                    'Quantités' => $qty,
                ];
        })->sortBy('Produits');

        return $this->exportExcel('Produits', $products);
    }

    public function badges()
    {
        $badges = Badge::with(['company'])->get()->map(function (Badge $badge) {
                return [
                    'Entreprise' => $badge->company->name,
                    'Prénom' => $badge->first_name,
                    'Nom' => $badge->last_name,
                ];
        })->sortBy('Entreprise');

        return $this->exportExcel('Badges', $badges);
    }

    public function results()
    {
        $orders = Order::with(['company'])->get()->map(function (Order $order) {
            /** @var OptionDetail $detail */
            $isSelect = $order->option->type == 'select';
            $detail =  $isSelect ?
                $order->option->details->find($order->value) :
                $order->option->details->first();
            return [
                    'Entreprise' => $order->company->name,
                    'Option' => $detail->label_with_option,
                    'Prix unitaire' => $detail->price,
                    'Quantité' => $isSelect ? 1 : $order->value,
                    'Prix total' => $order->price
                ];
        })->sortBy('Entreprise');

        $companies = Company::with(['orders'])->get()->map(function (Company $company) {
            return [
                'Entreprise' => $company->name,
                'Montant total' => Order::totalPrice($company->id),
            ];
        });

        return $this->excel->create('Résultats', function (LaravelExcelWriter $excel) use ($companies, $orders) {
            $excel->sheet('Résumé', function (LaravelExcelWorksheet $sheet) use ($companies) {
                $sheet->freezeFirstRow();
                $sheet->fromModel($companies);
            });
            $excel->sheet('Détail', function (LaravelExcelWorksheet $sheet) use ($orders) {
                $sheet->freezeFirstRow();
                $sheet->fromModel($orders);
            });
        })->download('xlsx');
    }

    private function exportExcel($type, $collection)
    {
        return $this->excel->create($type, function (LaravelExcelWriter $excel) use ($collection, $type) {
            $excel->sheet($type, function (LaravelExcelWorksheet $sheet) use ($collection) {
                $sheet->freezeFirstRow();
                $sheet->fromModel($collection);
            });
        })->download('xlsx');
    }
}
