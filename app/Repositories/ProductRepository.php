<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\Product;

class ProductRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Product::class;
    }
}
