<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Larapie\Contracts\DirectTransformableContract;

/**
 * App\Models\Category
 *
 * @property integer $id
 * @property string $name
 * @property string $color
 * @property string $map
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereColor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereMap($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model implements DirectTransformableContract
{
    const UPLOAD_PATH = 'img/uploads/categories/';
    protected $fillable = ['name', 'color', 'map'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function directTransform()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'map_url' => asset($this->map),
        ];
    }

    public function addMap(Request $request)
    {
        if ($request->file('map')->isValid()) {
            $map = $request->file('map');
            $destinationPath = self::UPLOAD_PATH;
            $extension = $map->getClientOriginalExtension();
            $fileName = str_random() . '.' . $extension;
            if ($request->file('map')->move($destinationPath, $fileName)) {
                $this->deleteMap();
                $this->map = $destinationPath . $fileName;
            };
        }
    }

    public function deleteMap()
    {
        if (!empty($this->map)) {
            \File::delete(public_path($this->map));
        }
    }

    public function delete()
    {
        $this->deleteMap();
        parent::delete();
    }
}
