<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
class Post extends Model
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
