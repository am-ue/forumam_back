<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Larapie\Contracts\DirectTransformableContract;

/**
 * App\Models\Company
 *
 * @property integer $id
 * @property string $name
 * @property string $website
 * @property string $description
 * @property string $summary
 * @property string $figures
 * @property string $staffing
 * @property string $profiles
 * @property string $more
 * @property string $logo
 * @property string $stand
 * @property string $billing_contact
 * @property string $billing_address
 * @property string $billing_delay
 * @property string $billing_method
 * @property integer $category_id
 * @property boolean $active
 * @property boolean $public
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Category $category
 * @property-read mixed $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Badge[] $badges
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereSummary($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereFigures($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereStaffing($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereProfiles($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereMore($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereStand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereBillingContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereBillingAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereBillingDelay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereBillingMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company wherePublic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company showable()
 * @mixin \Eloquent
 */
class Company extends Model implements DirectTransformableContract
{
    const UPLOAD_PATH = 'img/uploads/companies/';
    public static $billing_methods = ['Chèque', 'Virement', 'CB'];
    public $guarded = ['stand', 'active', 'public', 'logo'];
    public $appends = ['contact'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getContactAttribute()
    {
        return $this->users()->first();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function badges()
    {
        return $this->hasMany(Badge::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeShowable($query)
    {
        /** @var Company $query */
        return $query->whereActive(1)->wherePublic(1);
    }

    public function directTransform()
    {
        $posts = $this->posts ? $this->posts->map(function (Post $post) {
            return $post->directTransform();
        }) : null;
        return array_filter([
            'id'          => $this->id,
            'name'        => $this->name,
            'website'     => $this->website,
            'logo_url'    => asset($this->logo),
            'summary'     => $this->summary,
            'description' => $this->description,
            'figures'     => $this->figures,
            'staffing'    => $this->staffing,
            'profiles'    => $this->profiles,
            'more'        => $this->more,
            'stand'       => $this->stand,
            'category'    => $this->category ? $this->category->directTransform() : null,
            'posts'       => $posts,
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ]);
    }

    public function toMinArray()
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'logo_url' => asset($this->logo),
            'summary'  => $this->summary,
        ];
    }

    public function delete()
    {
        User::whereCompanyId($this->id)->delete();
        parent::delete();
    }

    public function completePercentage()
    {
        $attributes = [
            'name',
            'website',
            'description',
            'figures',
            'staffing',
            'profiles',
            'logo',
            'billing_contact',
            'billing_address',
            'billing_delay',
            'billing_method',
        ];
        $percentage = 0;
        foreach ($attributes as $attribute) {
            if (!empty($this->$attribute)) {
                $percentage += (100 / count($attributes));
            }
        }
        return round($percentage);
    }
}
