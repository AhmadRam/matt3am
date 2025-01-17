<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\ProductCrossSell;

class ProductCrossSellRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return ProductCrossSell::class;
    }
}
