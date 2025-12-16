<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'local',
        'iso',
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
     * The addresses that belong to the country.
     */
    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class, 'country_zone', 'country_id', 'address_id')->withTimestamps();
    }

    /**
     * The zones that belong to the country.
     */
    public function zones(): BelongsToMany
    {
        return $this->belongsToMany(Zone::class, 'country_zone', 'country_id', 'zone_id')->withTimestamps();
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