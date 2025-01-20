<?php

namespace App\Models;

use App\Contracts\Section as ContractsSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Section",
 *     required={"name", "restaurant_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Main Section"),
 *     @OA\Property(property="description", type="string", example="A description of the section."),
 *     @OA\Property(property="meta_title", type="string", example="Main Section Meta Title"),
 *     @OA\Property(property="meta_keywords", type="string", example="main, section"),
 *     @OA\Property(property="meta_description", type="string", example="Description for the main section"),
 *     @OA\Property(property="restaurant_id", type="integer", example=5),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-01T00:00:00Z")
 * )
 */
class Section extends Model implements ContractsSection
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'restaurant_id',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
