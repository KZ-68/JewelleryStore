<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Zone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    // Create a slug automaticaly after the creation of the zone
    public static function boot()
    {
        parent::boot();

        static::creating(function ($zone) {
            $slug = Str::slug($zone->name);

            $count = Zone::where('slug', $slug)->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }

            $zone->slug = $slug;
        });
    }

    /**
    * The zones that belong to the country.
    */
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'country_zone', 'zone_id', 'country_id')->withTimestamps();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s'
        ];
    }
}