<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Company
 *
 * @property integer $id
 * @property string $name
 * @property string $website
 * @property string $description
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereDescription($value)
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
 * @mixin \Eloquent
 */
class Company extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
