<?php

namespace App\Models;

use App\Contracts\Restaurant as ContractsRestaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * @OA\Schema(
 *     schema="Restaurant",
 *     required={"subscription_start_date", "subscription_end_date", "user_id", "currency_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="phone_code", type="string", nullable=true, example="+1"),
 *     @OA\Property(property="phone", type="string", nullable=true, example="123456789"),
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="subscription_start_date", type="string", format="date", example="2025-01-01"),
 *     @OA\Property(property="subscription_end_date", type="string", format="date", example="2026-01-01"),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="currency_id", type="integer", example=1),
 *     @OA\Property(
 *         property="translations",
 *         type="object",
 *         @OA\Property(
 *             property="en",
 *             type="object",
 *             @OA\Property(property="name", type="string", example="Restaurant Name"),
 *             @OA\Property(property="description", type="string", nullable=true, example="A brief description"),
 *             @OA\Property(property="address", type="string", nullable=true, example="123 Main St"),
 *             @OA\Property(property="logo", type="string", format="binary", description="Restaurant logo"),
 *             @OA\Property(property="meta_title", type="string", nullable=true),
 *             @OA\Property(property="meta_keywords", type="string", nullable=true),
 *             @OA\Property(property="meta_description", type="string", nullable=true)
 *         ),
 *         @OA\Property(
 *             property="ar",
 *             type="object",
 *             @OA\Property(property="name", type="string", example="اسم المطعم"),
 *             @OA\Property(property="description", type="string", nullable=true, example="وصف مختصر"),
 *             @OA\Property(property="address", type="string", nullable=true, example="123 الشارع الرئيسي"),
 *             @OA\Property(property="logo", type="string", format="binary", description="شعار المطعم"),
 *             @OA\Property(property="meta_title", type="string", nullable=true),
 *             @OA\Property(property="meta_keywords", type="string", nullable=true),
 *             @OA\Property(property="meta_description", type="string", nullable=true)
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Restaurant extends Model implements ContractsRestaurant, TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = [
        'phone_code',
        'phone',
        'status',
        'subscription_start_date',
        'subscription_end_date',
        'user_id',
        'currency_id'
    ];

    // الحقول المترجمة
    public $translatedAttributes = [
        'name',
        'description',
        'address',
        'logo',
        'meta_title',
        'meta_keywords',
        'meta_description'
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
