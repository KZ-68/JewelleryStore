<?php

namespace App\Models;

use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    * The statuses that belong to the order.
    */
    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(Status::class, 'order_status', 'order_id', 'status_id')->withTimestamps();
    }

    
    /**
    * The products that belong to the order.
    */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withTimestamps();
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