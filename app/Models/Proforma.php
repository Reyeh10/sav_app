<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proforma extends Model
{
    use HasFactory;

    public const STAMP_AMOUNT = 1000.00;
    public const VAT_RATE = 10.00;

    public const TYPE_WITH_TAX = 'with_tax';
    public const TYPE_WITHOUT_TAX = 'without_tax';

    protected $fillable = [
        'vehicle_id',
        'customer_id',
        'created_by',
        'proforma_price',
        'discount_percent',
        'discount_amount',
        'invoice_type',
        'type_client',
        'payment_type',
        'status',
        'proforma_date',
        'valid_until',
        'notes',
        'sale_id',
        'converted_at',
        'converted_by',
        'cancelled_at',
        'cancelled_by',
        'show_free_services',
    ];

    protected $casts = [
        'proforma_price'   => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount'  => 'decimal:2',
        'proforma_date'    => 'datetime',
        'show_free_services' => 'boolean',
        'valid_until'      => 'date',
        'converted_at'     => 'datetime',
        'cancelled_at'     => 'datetime',
    ];

    protected $attributes = [
        'invoice_type'     => self::TYPE_WITH_TAX,
        'discount_percent' => 0,
        'discount_amount'  => 0,
        'status'           => 'Validé',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function convertedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'converted_by');
    }

    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function getProformaNumberAttribute($value): string
    {
        if (!empty($value)) {
            return (string) $value;
        }

        return 'PROFORMA-' . str_pad(
            (string) $this->getKey(),
            6,
            '0',
            STR_PAD_LEFT
        );
    }

    public function getHasTaxAttribute(): bool
    {
        return $this->invoice_type !== self::TYPE_WITHOUT_TAX;
    }

    public function getInvoiceTypeLabelAttribute(): string
    {
        return $this->has_tax
            ? 'Proforma avec taxes'
            : 'Proforma sans taxes';
    }

    public function getVehicleHtAmountAttribute(): float
    {
        return round((float) ($this->proforma_price ?? 0), 2);
    }

    public function getStampAmountAttribute(): float
    {
        return $this->has_tax
            ? round(self::STAMP_AMOUNT, 2)
            : 0.00;
    }

    public function getDiscountRateAttribute(): float
    {
        return round(
            max(0, min(100, (float) ($this->discount_percent ?? 0))),
            2
        );
    }

    public function getProformaDiscountAmountAttribute(): float
    {
        $stored = round(
            max(0, (float) ($this->discount_amount ?? 0)),
            2
        );

        if ($stored > 0) {
            return min($stored, $this->vehicle_ht_amount);
        }

        return round(
            $this->vehicle_ht_amount * ($this->discount_rate / 100),
            2
        );
    }

    public function getSubtotalHtAttribute(): float
    {
        return round(
            $this->vehicle_ht_amount + $this->stamp_amount,
            2
        );
    }

    public function getNetHtAttribute(): float
    {
        return round(
            max(
                0,
                $this->vehicle_ht_amount
                - $this->proforma_discount_amount
                + $this->stamp_amount
            ),
            2
        );
    }

    public function getVatAmountAttribute(): float
    {
        if (!$this->has_tax) {
            return 0.00;
        }

        return round(
            $this->net_ht * (self::VAT_RATE / 100),
            2
        );
    }

    public function getTotalAmountAttribute(): float
    {
        return round(
            $this->net_ht + $this->vat_amount,
            2
        );
    }

    public function getFreeServicesAttribute(): array
    {
        if (!$this->has_tax) {
            return [
                'Frais d’assurance automobile — 1 an',
            ];
        }

        return [
            'Frais d’assurance automobile — 1 an',
            'Plaque d’immatriculation',
            'Carte grise',
            'Vignette',
            'Antirouille',
            'Tapis au sol',
        ];
    }

    public function isConvertible(): bool
    {
        if (!in_array($this->status, ['Brouillon', 'Validé'], true)) {
            return false;
        }

        if ($this->valid_until && $this->valid_until->isPast()) {
            return false;
        }

        return $this->vehicle?->status === 'Disponible';
    }
}
