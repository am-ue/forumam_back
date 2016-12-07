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
 * @property-read \App\Models\Option $option
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionRelation[] $parentsRelations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionRelation[] $childrenRelations
 * @property-read mixed $label_with_option
 * @property-read mixed $label_with_price
 * @property-read mixed $label_with_all
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
    public $appends = ['label_with_option', 'label_with_price', 'label_with_all'];

    public function setPriceAttribute($value)
    {
        return $this->attributes['price'] = round($value * 100);
    }

    public function getPriceAttribute()
    {
        return $this->attributes['price'] / 100;
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function parentsRelations()
    {
        return $this->hasMany(OptionRelation::class, 'child_id');
    }

    public function childrenRelations()
    {
        return $this->hasMany(OptionRelation::class, 'parent_id');
    }

    public function getLabelWithOptionAttribute()
    {
        return $this->option->name . ($this->label ? ' : ' . $this->label : '');
    }

    public function getLabelWithPriceAttribute()
    {
        return $this->label . ' [ ' . $this->price . ' € ]';
    }

    public function getLabelWithAllAttribute()
    {
        return  $this->option->name . ($this->label ? ' : ' . $this->label : '') . ' [ ' . $this->price . ' € ]';
    }
}
