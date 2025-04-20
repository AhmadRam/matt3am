<?php

namespace App\Models;

use App\Contracts\Section as ContractsSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * @OA\Schema(
 *     schema="Section",
 *     required={"restaurant_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="restaurant_id", type="integer", example=1),
 *     @OA\Property(
 *         property="translations",
 *         type="object",
 *         @OA\Property(
 *             property="en",
 *             type="object",
 *             @OA\Property(property="name", type="string", example="Main Section"),
 *             @OA\Property(property="description", type="string", nullable=true),
 *             @OA\Property(property="meta_title", type="string", nullable=true),
 *             @OA\Property(property="meta_keywords", type="string", nullable=true),
 *             @OA\Property(property="meta_description", type="string", nullable=true)
 *         ),
 *         @OA\Property(
 *             property="ar",
 *             type="object",
 *             @OA\Property(property="name", type="string", example="القسم الرئيسي"),
 *             @OA\Property(property="description", type="string", nullable=true),
 *             @OA\Property(property="meta_title", type="string", nullable=true),
 *             @OA\Property(property="meta_keywords", type="string", nullable=true),
 *             @OA\Property(property="meta_description", type="string", nullable=true)
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Section extends Model implements ContractsSection, TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = [
        'restaurant_id',
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
}
