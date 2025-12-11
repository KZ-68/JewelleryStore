<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'carrier_id',
        'customer_id',
        'reference',
        'gift',
        'gift_message',
        'note',
        'invoice_date',
        'delivery_date',
        'valid',
        'returned'
    ];

     // Create a reference automaticaly after the creation of the order
    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            do {
                $ref = 'CMD-' . strtoupper(Str::random(10));
            } while (self::where('reference', $ref)->exists());
        });
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'invoice_date' => 'datetime:Y-m-d H:i:s',
            'delivery_date' => 'datetime:Y-m-d H:i:s',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }
}