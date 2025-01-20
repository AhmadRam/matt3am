<?php

namespace App\Models;

use App\Contracts\CurrencyExchangeRate as ContractsCurrencyExchangeRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CurrencyExchangeRate",
 *     type="object",
 *     required={"base_currency", "target_currency", "rate"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="base_currency", type="integer", example=1),
 *     @OA\Property(property="target_currency", type="integer", example=2),
 *     @OA\Property(property="rate", type="number", format="float", example=1.23)
 * )
 */
class CurrencyExchangeRate extends Model implements ContractsCurrencyExchangeRate
{
    use HasFactory;

    protected $fillable = [
        'base_currency',
        'target_currency',
        'rate'
    ];

    /**
     * Get the base currency for the exchange rate.
     *
     * @return BelongsTo
     */
    public function baseCurrency() : BelongsTo
    {
        return $this->belongsTo(Currency::class, 'base_currency');
    }

    /**
     * Get the target currency for the exchange rate.
     *
     * @return BelongsTo
     */
    public function targetCurrency() : BelongsTo
    {
        return $this->belongsTo(Currency::class, 'target_currency');
    }
}
