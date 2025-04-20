<?php

namespace App\Models;

use App\Contracts\Currency as ContractsCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Currency",
 *     type="object",
 *     required={"code", "name", "symbol"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="code", type="string", example="USD"),
 *     @OA\Property(property="name", type="string", example="US Dollar"),
 *     @OA\Property(property="symbol", type="string", example="$"),
 *     @OA\Property(property="status", type="boolean", example=true)
 * )
 */
class Currency extends Model implements ContractsCurrency
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'status',
    ];

    /**
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/CurrencyExchangeRate")
     * )
     */
    public function exchangeRates() : HasMany
    {
        return $this->hasMany(CurrencyExchangeRate::class, 'base_currency');
    }
}
