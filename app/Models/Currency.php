<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

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

        // Create a slug automaticaly after the creation of the currency
    public static function boot()
    {
        parent::boot();

        static::creating(function ($currency) {
            $slug = Str::slug($currency->name);
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . $count++;
            }

            $currency->slug = $slug;
        });
    }

    /**
    * The categories that belong to the product.
    */
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'country_currency', 'currency_id', 'country_id')->withTimestamps();
    }
}