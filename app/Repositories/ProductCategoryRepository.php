<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\ProductCategory;

class ProductCategoryRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return ProductCategory::class;
    }
}
