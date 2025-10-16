<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'reference',
        'ean13',
        'quantity',
        'retailPrice',
        'active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'reference' => 'string',
            'ean13' => 'string',
            'retailPrice' => 'float',
            'active' => 'boolean',
        ];
    }
}
