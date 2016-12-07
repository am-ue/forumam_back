<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OptionRelation
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $parent_value
 * @property integer $child_id
 * @property string $child_value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $name
 * @property-read \App\Models\OptionDetail $parent
 * @property-read \App\Models\OptionDetail $child
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionRelation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionRelation whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionRelation whereParentValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionRelation whereChildId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionRelation whereChildValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionRelation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionRelation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OptionRelation extends Model
{

    public $fillable = ['parent_id', 'child_id', 'parent_value', 'child_value'];

    public function getNameAttribute()
    {
        return $this->parent->option->name . '/' . $this->child->option->name;
    }

    public function parent()
    {
        return $this->belongsTo(OptionDetail::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(OptionDetail::class, 'child_id');
    }
}
