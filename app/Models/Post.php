<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Larapie\Contracts\DirectTransformableContract;

/**
 * App\Models\Post
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $type
 * @property string $title
 * @property string $description
 * @property string $youtube_id
 * @property string $img
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Company $company
 * @property-read mixed $youtube_url
 * @property-read mixed $youtube_thumb
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereYoutubeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends Model implements DirectTransformableContract
{

    const UPLOAD_PATH = 'img/uploads/posts/';
    public static $types = ['article' => 'Article', 'video' => 'Vidéo Youtube'];
    public $fillable = ['company_id', 'type', 'title', 'description'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getYoutubeUrlAttribute()
    {
        return $this->youtube_id ? 'https://www.youtube.com/watch?v=' . $this->youtube_id : null;
    }
    public function getYoutubeThumbAttribute()
    {
        return $this->youtube_id ? 'http://img.youtube.com/vi/' . $this->youtube_id . '/hqdefault.jpg' : null;
    }

    public function directTransform()
    {
        /** @var Company $company */
        $company = $this->company()->get(['id', 'name', 'summary', 'logo'])->first();
        return array_filter([
            'id'          => $this->id,
            'type'        => $this->type,
            'title'       => $this->title,
            'description' => $this->description,
            'youtube_id'  => $this->youtube_id,
            'img_url'     => $this->img ? asset($this->img) : null,
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
            'company'     => $company ? $company->toMinArray() : null,
        ]);
    }

    public function addImg(Request $request)
    {
        if ($request->file('img')->isValid()) {
            $img = $request->file('img');
            $destinationPath = self::UPLOAD_PATH;
            $extension = $img->getClientOriginalExtension();
            $fileName = str_random() . '.' . $extension;
            if ($request->file('img')->move($destinationPath, $fileName)) {
                $this->deleteImg();
                $this->img = $destinationPath . $fileName;
            };
        }
    }

    public function deleteImg()
    {
        if (!empty($this->img)) {
            \File::delete(public_path($this->img));
        }
    }

    public function delete()
    {
        $this->deleteImg();
        parent::delete();
    }
}
