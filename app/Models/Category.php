<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *     schema="Category",
 *     required={"name", "description"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Appetizers"),
 *     @OA\Property(property="description", type="string", example="Starter meals for your menu."),
 *     @OA\Property(property="position", type="integer", example=1),
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(
 *         property="image",
 *         type="string",
 *         format="binary",
 *         example="image.jpg",
 *         description="Profile image of the user"
 *     ),
 *     @OA\Property(property="slug", type="string", example="appetizers"),
 *     @OA\Property(property="url_key", type="string", example="appetizers-url"),
 *     @OA\Property(property="meta_title", type="string", example="Appetizers Meta Title"),
 *     @OA\Property(property="meta_description", type="string", example="Appetizers Meta Description"),
 *     @OA\Property(property="meta_keywords", type="string", example="appetizers, starter meals"),
 *     @OA\Property(property="restaurant_id", type="integer", example=5),
 *     @OA\Property(property="currency_id", type="integer", example=2)
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'status',
        'image',
        'slug',
        'url_key',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'restaurant_id',
        'currency_id'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
