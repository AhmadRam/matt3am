<?php

namespace App\Models;

use App\Contracts\ProductCategory as ContractsProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCategory extends Model implements ContractsProductCategory
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category_id'
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
