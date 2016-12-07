<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Badge
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $first_name
 * @property string $last_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Badge extends Model
{
    protected $fillable = ['first_name', 'last_name'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
