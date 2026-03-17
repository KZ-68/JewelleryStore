<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'number',
        'symbol'
    ];

    /**
    * The categories that belong to the product.
    */
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'country_currency', 'currency_id', 'country_id')->withTimestamps();
    }
}