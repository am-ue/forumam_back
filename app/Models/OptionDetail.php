<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OptionDetail
 *
 * @property integer $id
 * @property integer $option_id
 * @property string $label
 * @property integer $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionDetail whereOptionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionDetail whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionDetail wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OptionDetail extends Model
{
    public $fillable = ['label', 'price'];

    public function setPriceAttribute($value)
    {
        return $this->attributes['price'] = round($value * 100);
    }

    public function getPriceAttribute()
    {
        return $this->attributes['price'] / 100;
    }
}
