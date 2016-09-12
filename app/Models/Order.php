<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $option_id
 * @property integer $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOptionDetailsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $price
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\OptionDetail $optionDetail
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePrice($value)
 * @property-read \App\Models\Option $option
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOptionId($value)
 * @property integer $parent_option_id
 * @property-read mixed $labeled_value
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereParentOptionId($value)
 * @property-read \App\Models\Option $parentOption
 */
class Order extends Model
{
    public $fillable = ['option_id', 'value', 'price', 'parent_option_id'];
    public $appends = ['labeled_value'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
    public function parentOption()
    {
        return $this->belongsTo(Option::class, 'parent_option_id');
    }

    public function getLabeledValueAttribute()
    {
        switch ($this->option->type){
            case 'select' :
                $labeled_value = OptionDetail::find($this->value)->label;
                break;
            case 'checkbox' :
                $labeled_value = $this->value ? 'Oui' : 'Non';
                break;
            default :
                $labeled_value = $this->value;
                break;
        }
        return $labeled_value;
    }

    public function isAddedWithAnotherOrder()
    {
        return $this->option_id != $this->parent_option_id;
    }
}
