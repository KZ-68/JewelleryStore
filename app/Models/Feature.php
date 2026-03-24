<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Feature extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    // Create a slug automaticaly after the creation of the feature
    public static function boot()
    {
        parent::boot();

        static::creating(function ($feature) {
            $slug = Str::slug($feature->name);

            $count = Feature::where('slug', $slug)->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }

            $feature->slug = $slug;
        });
    }

    /**
    * The products that belong to the feature.
    */
    public function values(): HasMany
    {
        return $this->hasMany(FeatureValue::class);
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
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }
}
