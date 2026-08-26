<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sale extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | CONSTANTES
    |--------------------------------------------------------------------------
    */

    /**
     * Montant fixe du timbre pour une facture avec taxes.
     */
    public const STAMP_AMOUNT = 1000.00;

    /**
     * Taux de TVA appliqué aux factures avec taxes.
     */
    public const VAT_RATE = 10.00;

    /**
     * Types de factures disponibles.
     */
    public const INVOICE_TYPE_WITH_TAX = 'with_tax';

    public const INVOICE_TYPE_WITHOUT_TAX = 'without_tax';

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTS AUTORISÉS
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'vehicle_id',
        'customer_id',
        'sold_by',

        'sold_price',
        'discount_percent',
        'discount_amount',

        'sold_date',
        'payment_type',
        'invoice_type',

        'invoice_status',
        'paid_amount',
        'remaining_amount',
        'payment_discount_amount',
        'paid_at',

        'cancelled_at',
        'cancelled_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | CONVERSIONS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'sold_date'        => 'datetime',
        'paid_at'          => 'datetime',
        'cancelled_at'     => 'datetime',

        'sold_price'       => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount'  => 'decimal:2',
        'paid_amount'      => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'payment_discount_amount' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | VALEURS PAR DÉFAUT
    |--------------------------------------------------------------------------
    */

    protected $attributes = [
        'invoice_type'     => self::INVOICE_TYPE_WITH_TAX,
        'invoice_status'   => 'Vendu',
        'discount_percent' => 0,
        'discount_amount'  => 0,
        'paid_amount'      => 0,
        'payment_discount_amount' => 0,
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Véhicule associé à la vente.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Client associé à la vente.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Utilisateur ayant réalisé la vente.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sold_by');
    }

    /**
     * Relation conservée pour les anciennes vues.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sold_by');
    }

    /**
     * Utilisateur ayant annulé la facture.
     */
    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * Proforma liée à la vente.
     */
    public function proforma(): HasOne
    {
        return $this->hasOne(Proforma::class, 'sale_id');
    }

    /*
    new functionnalties
    */
    public function payments()
    {
        return $this->hasMany(SalePayment::class);
    }

    public function getCalculatedPaidAmountAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function getCalculatedRemainingAmountAttribute(): float
    {
        return max(
            0,
            round(
                (float) $this->total_ttc
                - (float) $this->payments()->sum('amount')
                - (float) ($this->payment_discount_amount ?? 0),
                2
            )
        );
    }

    public function isFullyPaid(): bool
    {
        return (float) $this->remaining_amount <= 0;
    }
    /*
    |--------------------------------------------------------------------------
    | TYPE DE FACTURE
    |--------------------------------------------------------------------------
    */

    /**
     * Vérifie si la facture contient la TVA et le timbre.
     */
    public function getHasTaxAttribute(): bool
    {
        return $this->invoice_type !== self::INVOICE_TYPE_WITHOUT_TAX;
    }

    /**
     * Vérifie si la facture est une facture sans taxes.
     */
    public function getIsWithoutTaxAttribute(): bool
    {
        return !$this->has_tax;
    }

    /**
     * Libellé du type de facture.
     */
    public function getInvoiceTypeLabelAttribute(): string
    {
        return $this->has_tax
            ? 'Facture avec taxes'
            : 'Facture sans taxes';
    }

    /*
    |--------------------------------------------------------------------------
    | CALCULS DE LA FACTURE
    |--------------------------------------------------------------------------
    */

    /**
     * Prix HT du véhicule.
     */
    public function getVehicleHtAmountAttribute(): float
    {
        return round(
            (float) ($this->sold_price ?? 0),
            2
        );
    }

    /**
     * Montant du timbre.
     *
     * Facture avec taxes  : 1 000 FDJ.
     * Facture sans taxes  : 0 FDJ.
     */
    public function getStampAmountAttribute(): float
    {
        if (!$this->has_tax) {
            return 0.00;
        }

        return round(
            self::STAMP_AMOUNT,
            2
        );
    }

    /**
     * Pourcentage de remise sécurisé entre 0 et 100.
     */
    public function getDiscountRateAttribute(): float
    {
        return round(
            max(
                0,
                min(
                    100,
                    (float) ($this->discount_percent ?? 0)
                )
            ),
            2
        );
    }

    /**
     * Montant de la remise.
     *
     * La remise est appliquée uniquement au prix du véhicule.
     * Le timbre n'est jamais remisé.
     */
    public function getInvoiceDiscountAmountAttribute(): float
    {
        $maximumDiscount = $this->vehicle_ht_amount;

        $storedAmount = round(
            max(
                0,
                (float) ($this->discount_amount ?? 0)
            ),
            2
        );

        /*
         * Si un montant a déjà été enregistré dans la base,
         * il est utilisé sans pouvoir dépasser le prix du véhicule.
         */
        if ($storedAmount > 0) {
            return min(
                $storedAmount,
                $maximumDiscount
            );
        }

        /*
         * Sinon, le montant est recalculé depuis le pourcentage.
         */
        $calculatedAmount = round(
            $this->vehicle_ht_amount
            * ($this->discount_rate / 100),
            2
        );

        return min(
            $calculatedAmount,
            $maximumDiscount
        );
    }

    /**
     * Prix net du véhicule après remise.
     */
    public function getVehicleNetHtAttribute(): float
    {
        return round(
            max(
                0,
                $this->vehicle_ht_amount
                - $this->invoice_discount_amount
            ),
            2
        );
    }

    /**
     * Total HT avant remise.
     *
     * Avec taxes :
     * prix du véhicule + timbre.
     *
     * Sans taxes :
     * prix du véhicule uniquement.
     */
    public function getSubtotalHtAttribute(): float
    {
        return round(
            $this->vehicle_ht_amount
            + $this->stamp_amount,
            2
        );
    }

    /**
     * Total HT net après remise.
     *
     * Avec taxes :
     * prix véhicule - remise + timbre.
     *
     * Sans taxes :
     * prix véhicule - remise.
     */
    public function getNetHtAttribute(): float
    {
        return round(
            max(
                0,
                $this->vehicle_net_ht
                + $this->stamp_amount
            ),
            2
        );
    }

    /**
     * TVA.
     *
     * Avec taxes :
     * total HT net × 10 %.
     *
     * Sans taxes :
     * 0 FDJ.
     */
    public function getVatAmountAttribute(): float
    {
        if (!$this->has_tax) {
            return 0.00;
        }

        return round(
            $this->net_ht
            * (self::VAT_RATE / 100),
            2
        );
    }

    /**
     * Total final de la facture.
     *
     * Avec taxes :
     * total HT net + TVA.
     *
     * Sans taxes :
     * prix véhicule après remise.
     */
    public function getTotalTtcAttribute(): float
    {
        return round(
            $this->net_ht
            + $this->vat_amount,
            2
        );
    }

    /**
     * Alias utile pour les factures sans taxes.
     */
    public function getTotalPayableAttribute(): float
    {
        return $this->total_ttc;
    }

    /*
    |--------------------------------------------------------------------------
    | PRESTATIONS OFFERTES
    |--------------------------------------------------------------------------
    */

    /**
     * Prestations gratuites affichées sur la facture.
     */
    public function getFreeServicesAttribute(): array
    {
        if ($this->is_without_tax) {
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

    /*
    |--------------------------------------------------------------------------
    | NUMÉRO DE FACTURE
    |--------------------------------------------------------------------------
    */

    /**
     * Numéro de facture généré automatiquement.
     *
     * Si une colonne invoice_number existe et contient une valeur,
     * cette valeur est utilisée.
     */
    public function getInvoiceNumberAttribute($value): string
    {
        if (!empty($value)) {
            return (string) $value;
        }

        return 'FACTURE-' . str_pad(
            (string) $this->getKey(),
            6,
            '0',
            STR_PAD_LEFT
        );
    }
}
