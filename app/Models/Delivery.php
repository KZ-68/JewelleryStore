<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Delivery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'description',
        'type',
        'delivery_price',
    ];

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

    /**
    * The addresses that belong to the group.
    */
    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class, 'delivery_address', 'delivery_id', 'address_id')->withTimestamps();
    }

    public function latestAddress(): BelongsToMany
    {
        return $this->belongsToMany(Address::class, 'delivery_address', 'delivery_id', 'address_id')
            ->withTimestamps()
            ->orderByPivot('created_at', 'desc')
            ->limit(1);
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }
}
