<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\ProductImage;

class ProductImageRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return ProductImage::class;
    }
}
