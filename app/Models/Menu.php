<?php

namespace App\Models;

use App\Contracts\Menu as ContractsMenu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * @OA\Schema(
 *     schema="Menu",
 *     required={"restaurant_id", "currency_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="restaurant_id", type="integer", example=5),
 *     @OA\Property(property="currency_id", type="integer", example=2),
 *     @OA\Property(
 *         property="translations",
 *         type="object",
 *         @OA\Property(
 *             property="en",
 *             type="object",
 *             @OA\Property(property="name", type="string", example="Main Menu"),
 *             @OA\Property(property="description", type="string", nullable=true),
 *             @OA\Property(property="meta_title", type="string", nullable=true),
 *             @OA\Property(property="meta_keywords", type="string", nullable=true),
 *             @OA\Property(property="meta_description", type="string", nullable=true)
 *         ),
 *         @OA\Property(
 *             property="ar",
 *             type="object",
 *             @OA\Property(property="name", type="string", example="القائمة الرئيسية"),
 *             @OA\Property(property="description", type="string", nullable=true),
 *             @OA\Property(property="meta_title", type="string", nullable=true),
 *             @OA\Property(property="meta_keywords", type="string", nullable=true),
 *             @OA\Property(property="meta_description", type="string", nullable=true)
 *         )
 *     )
 * )
 */
class Menu extends Model implements ContractsMenu, TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = [
        'restaurant_id',
        'currency_id',
    ];

    // الحقول المترجمة
    public $translatedAttributes = [
        'name',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
