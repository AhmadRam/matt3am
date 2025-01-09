<?php

namespace App\Models;

use App\Contracts\Menu as ContractsMenu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Menu",
 *     required={"name", "restaurant_id", "currency_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Main Menu"),
 *     @OA\Property(property="restaurant_id", type="integer", example=5),
 *     @OA\Property(property="currency_id", type="integer", example=2),
 *     @OA\Property(property="meta_title", type="string", example="Main Menu Meta Title"),
 *     @OA\Property(property="meta_keywords", type="string", example="menu, food, main"),
 *     @OA\Property(property="meta_description", type="string", example="Main menu description for the restaurant."),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-01T00:00:00Z")
 * )
 */
class Menu extends Model implements ContractsMenu
{
    use HasFactory;

    protected $fillable = [
        'name',
        'restaurant_id',
        'currency_id',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(RestaurantProxy::modelClass());
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(CurrencyProxy::modelClass());
    }
}
