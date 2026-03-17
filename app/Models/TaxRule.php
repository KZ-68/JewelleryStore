<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxRule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'behavior',
        'rate_order'
    ];
    
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public function taxRuleGroup(): BelongsTo
    {
        return $this->belongsTo(TaxRuleGroup::class);
    }
}