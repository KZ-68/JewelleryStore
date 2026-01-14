<?php

namespace App\Models;

use App\Models\TaxRule;
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
        'active'
    ];

    public function taxRules(): HasMany
    {
        return $this->hasMany(TaxRule::class);
    }
}