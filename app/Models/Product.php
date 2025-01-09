<?php

namespace App\Models;

use App\Contracts\Product as ContractsProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Product",
 *     required={"sku", "name", "price", "quantity"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="sku", type="string", example="PROD001"),
 *     @OA\Property(property="name", type="string", example="Product Name"),
 *     @OA\Property(property="url_key", type="string", example="product-name"),
 *     @OA\Property(property="description", type="string", example="Full description of the product."),
 *     @OA\Property(property="short_description", type="string", example="Short description of the product."),
 *     @OA\Property(property="meta_title", type="string", example="Product Meta Title"),
 *     @OA\Property(property="meta_keywords", type="string", example="product, item, sale"),
 *     @OA\Property(property="meta_description", type="string", example="Meta description for the product."),
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="new", type="boolean", example=false),
 *     @OA\Property(property="featured", type="boolean", example=true),
 *     @OA\Property(property="price", type="number", format="float", example=99.99),
 *     @OA\Property(property="special_price", type="number", format="float", example=89.99),
 *     @OA\Property(property="quantity", type="integer", example=100),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-01T00:00:00Z")
 * )
 */
class Product extends Model implements ContractsProduct
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'url_key',
        'description',
        'short_description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'status',
        'new',
        'featured',
        'price',
        'special_price',
        'quantity'
    ];

    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(CategoryProxy::modelClass(), 'product_categories');
    }

    public function images() : HasMany
    {
        return $this->hasMany(ProductImageProxy::modelClass());
    }

    public function upSells() : HasMany
    {
        return $this->hasMany(ProductUpSellProxy::modelClass(), 'parent_id');
    }

    public function crossSells() : HasMany
    {
        return $this->hasMany(ProductCrossSellProxy::modelClass(), 'parent_id');
    }
}
