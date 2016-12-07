<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Option
 *
 * @property integer $id
 * @property integer $order
 * @property string $name
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionDetail[] $details
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionRelation[] $childrenRelations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionRelation[] $parentsRelations
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Option extends Model
{

    public static $types = [
        'checkbox' => 'Case à cocher',
        'select' => 'Menu déroulant',
        'int' => 'Champ quantité'
    ];

    public $fillable = ['name', 'type', 'order'];

    public function details()
    {
        return $this->hasMany(OptionDetail::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function childrenRelations()
    {
        return $this->hasManyThrough(OptionRelation::class, OptionDetail::class, 'option_id', 'child_id');
    }

    public function parentsRelations()
    {
        return $this->hasManyThrough(OptionRelation::class, OptionDetail::class, 'option_id', 'parent_id');
    }

    public function delete()
    {
        self::where('order', '>', $this->order)->decrement('order');
        OptionDetail::whereOptionId($this->id)->delete();
        parent::delete();
    }
}
