<?php

namespace App\Models;

use App\Models\TaxRule;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tax extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'rate',
        'applicable',
        'type',
        'description'
    ];

        // Create a slug automaticaly after the creation of the tax
    public static function boot()
    {
        parent::boot();

        static::creating(function ($tax) {
            $slug = Str::slug($tax->name);

            $count = Tax::where('slug', $slug)->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }

            $tax->slug = $slug;
        });
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
            'deleted_at' => 'datetime:Y-m-d H:i:s'
        ];
    }

    public function taxRules(): HasMany
    {
        return $this->hasMany(TaxRule::class);
    }
}
