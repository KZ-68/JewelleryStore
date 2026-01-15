<?php

namespace App\Models;

use App\Models\TaxRule;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxRuleGroup extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'active'
    ];

    // Create a slug automaticaly after the creation of the tax rule group
    public static function boot()
    {
        parent::boot();

        static::creating(function ($taxRuleGroup) {
            $slug = Str::slug($taxRuleGroup->name);

            $count = TaxRuleGroup::where('slug', $slug)->count();
            if ($count) {
                $slug .= '-' . ($count + 1);
            }

            $taxRuleGroup->slug = $slug;
        });
    }

    public function taxRules(): HasMany
    {
        return $this->hasMany(TaxRule::class);
    }
}