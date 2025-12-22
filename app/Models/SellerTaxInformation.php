<?php

namespace App\Models;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerTaxInformation extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tax_country',
        'tax_type',
        'tax_number',
        'tax_scheme',
        'reduced_tax_rate',
        'tax_registration_status',
        'invoice_tax_label',
        'requires_tax_invoice',
        'qualified_invoice_number',
        'verification_status',
        ''
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
            'valid_from' => 'datetime:Y-m-d H:i:s',
            'valid_to' => 'datetime:Y-m-d H:i:s',
            'verified_at' => 'datetime:Y-m-d H:i:s'
        ];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}