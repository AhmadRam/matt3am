<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\ProductUpSell;

class ProductUpSellRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return ProductUpSell::class;
    }
}
