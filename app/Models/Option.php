<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Option
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionDetail[] $details
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionRelation[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionRelation[] $parents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionRelation[] $childrenRelations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionRelation[] $parentsRelations
 * @property integer $order
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Option whereOrder($value)
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

    public function order()
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
