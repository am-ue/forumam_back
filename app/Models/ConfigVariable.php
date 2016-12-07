<?php

namespace App\Models;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use Larapie\Contracts\DirectTransformableContract;

/**
 * App\Models\ConfigVariable
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfigVariable whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfigVariable whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfigVariable whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfigVariable whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfigVariable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ConfigVariable extends Model implements DirectTransformableContract
{
    public $fillable = ['key', 'value'];

    /**
     * Transform the instance to a serializable array.
     *
     * @return array
     */
    public function directTransform()
    {
        return [
            'key'   => $this->key,
            'value' => Markdown::convertToHtml(e($this->value)),
        ];
    }
}
