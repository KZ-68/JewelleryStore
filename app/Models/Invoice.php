<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'number',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->due_date)) {
                $model->due_date = Carbon::now()->addDays(30)->toDateString();
            }
        });
    }
       
    /**
    * The orders that belong to the invoice.
    */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'invoice_order', 'invoice_id', 'order_id')->withTimestamps();
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => \Carbon\Carbon::parse($value)->toDateString(),
        );
    }

    protected function dueDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => \Carbon\Carbon::parse($value)->toDateString(),
        );
    }
}
