<?php

namespace App\Models;

use App\Contracts\Table as ContractsTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * @OA\Schema(
 *     schema="Table",
 *     required={"section_id", "capacity"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="capacity", type="integer", example=4),
 *     @OA\Property(property="qr_code", type="string", example="qr123456"),
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="section_id", type="integer", example=2),
 *     @OA\Property(
 *         property="translations",
 *         type="object",
 *         @OA\Property(
 *             property="en",
 *             type="object",
 *             @OA\Property(property="name", type="string", example="Table 1"),
 *             @OA\Property(property="description", type="string", nullable=true),
 *             @OA\Property(property="meta_title", type="string", nullable=true),
 *             @OA\Property(property="meta_keywords", type="string", nullable=true),
 *             @OA\Property(property="meta_description", type="string", nullable=true)
 *         ),
 *         @OA\Property(
 *             property="ar",
 *             type="object",
 *             @OA\Property(property="name", type="string", example="طاولة 1"),
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
class Table extends Model implements ContractsTable, TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = [
        'capacity',
        'qr_code',
        'status',
        'section_id'
    ];

    // الحقول المترجمة
    public $translatedAttributes = [
        'name',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
