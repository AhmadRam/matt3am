<?php

namespace App\Models;

use App\Contracts\Restaurant as ContractsRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Restaurant",
 *     required={"name", "subscription_start_date", "subscription_end_date", "user_id", "currency_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Restaurant Name"),
 *     @OA\Property(property="description", type="string", nullable=true, example="A brief description of the restaurant."),
 *     @OA\Property(property="address", type="string", nullable=true, example="123 Main St, City, Country"),
 *     @OA\Property(property="phone_code", type="string", nullable=true, example="+1"),
 *     @OA\Property(property="phone", type="string", nullable=true, example="123456789"),
 *     @OA\Property(property="logo", type="string", nullable=true, example="logo.png"),
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="subscription_start_date", type="string", format="date", example="2025-01-01"),
 *     @OA\Property(property="subscription_end_date", type="string", format="date", example="2026-01-01"),
 *     @OA\Property(property="user_id", type="integer", example=1, description="The ID of the user associated with the restaurant."),
 *     @OA\Property(property="currency_id", type="integer", example=1, description="The ID of the currency associated with the restaurant."),
 *     @OA\Property(property="meta_title", type="string", nullable=true, example="Restaurant Meta Title"),
 *     @OA\Property(property="meta_keywords", type="string", nullable=true, example="restaurant, food, dining"),
 *     @OA\Property(property="meta_description", type="string", nullable=true, example="Meta description for the restaurant."),
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
        'phone_code',
        'phone',
        'logo',
        'status',
        'subscription_start_date',
        'subscription_end_date',
        'user_id',
        'currency_id',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}
