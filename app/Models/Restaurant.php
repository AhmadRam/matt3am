<?php

namespace App\Models;

use App\Contracts\Restaurant as ContractsRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Restaurant",
 *     required={"name", "address", "phone", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Restaurant Name"),
 *     @OA\Property(property="description", type="string", example="A brief description of the restaurant."),
 *     @OA\Property(property="address", type="string", example="123 Main St, City, Country"),
 *     @OA\Property(property="phone", type="string", example="+123456789"),
 *     @OA\Property(property="email", type="string", example="restaurant@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-01T00:00:00Z")
 * )
 */
class Restaurant extends Model implements ContractsRestaurant
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email'
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(SectionProxy::modelClass());
    }

    public function tables(): HasMany
    {
        return $this->hasMany(TableProxy::modelClass());
    }

    public function menus(): HasMany
    {
        return $this->hasMany(MenuProxy::modelClass());
    }
}
