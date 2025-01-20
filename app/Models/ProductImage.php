<?php

namespace App\Models;

use App\Contracts\ProductImage as ContractsProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model implements ContractsProductImage
{
    use HasFactory;

    protected $fillable = [
        'type',
        'path',
        'position',
        'product_id'
    ];

    public $timestamps = false;

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
